<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/9/2018
 * Time: 4:08 PM
 */

namespace Course\Http\Controllers\Frontend;

use Advertise\Models\Advertise;
use Course\Models\CourseCurriculumItems;
use Course\Repositories\CourseRepository;
use Barryvdh\Debugbar\Controllers\BaseController;
use Level\Repositories\LevelRepository;
use Course\Repositories\CourseCurriculumItemsRepository;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Qa\Repositories\QuestionRepository;
use Rating\Repositories\RatingRepository;
use Course\Models\Course;
use Users\Repositories\UsersRepository;
use Cache;

class CourseBuyController extends BaseController
{
    public function getIndex(
        $slug,
        CourseRepository $courseRepository,
        LevelRepository $levelRepository,
        CourseCurriculumItemsRepository $courseCurriculumItemsRepository,
        Request $request,
        QuestionRepository $questionRepository,
        RatingRepository $ratingRepository
    )
    {

        $course = Cache::remember('singleCourse-'.$slug, 60 * 60 * 24, function () use ($courseRepository, $slug) {
            return $courseRepository->with(['getLdp', 'getTarget', 'owner'])->findWhere(['slug' => $slug])->first();
        });

        //$course = $courseRepository->with(['getLdp', 'getTarget', 'owner'])->findWhere(['slug' => $slug])->first();

        $courseId = $course->id;
        if ($course->checkBought() || $course->type == 'exam') {
            $userId = Auth::id();
            //rating
            $rate = $ratingRepository->findWhere([
                'course' => $courseId,
                'author' => $userId
            ])->first();
            //lay bai dang hoc
            $lecture = $course->getLastCurriculum();
            $last_lecture_index = $courseCurriculumItemsRepository->findWhere([
                'course_id' => $courseId,
                'status' => 'active',
                ['type', '!=', 'section']
            ]);
            if ($last_lecture_index->where('id', $lecture->id)->count() > 0) {
                foreach ($last_lecture_index as $key => $item) {
                    if ($item->id == $lecture->id) {
                        $last_lecture_index = $key + 1;
                        break;
                    }
                }
            } else {
                $last_lecture_index = 1;
            }
            //số bài học đã hoàn thành
            $view = 'nqadmin-course::frontend.bought';
            $params = [
                'course' => $course,
                'last_lecture_index' => $last_lecture_index,
                'lecture' => $lecture,
                'rating_num' => isset($rate->rating_number) ? $rate->rating_number : 0,
                'rating_cont' => isset($rate->content) ? $rate->content : '',
            ];
            $tab = $request->tab ?? 2;
            switch ($tab) {
                case "1":
                    $view = 'nqadmin-course::frontend.bought';
                    break;
                case "2":
                    $keyword = $request->keyword;
                    $view = 'nqadmin-course::frontend.boughttab2';

                    $curriculum = Cache::remember('classes-'.$courseId.'-'.$keyword, 60 * 60 * 24, function () use ($courseId, $keyword) {
                        return CourseCurriculumItems::where('type', 'section')
                            ->where('course_id', $courseId)
                            ->where('status', 'active')
                            ->whereHas('getChildCurriculum', function ($query) use ($keyword, $courseId) {
                                if (!empty($keyword)) {
                                    $query->where('name', 'like', '%' . $keyword . '%');
                                    $query->orWhereHas('getMedia', function ($q) use ($keyword) {
                                        $q->where('url', 'like', '%' . $keyword . '%');
                                    });
                                }
                            })
                            ->with('getMedia')
                            ->with(['getChildCurriculum' => function ($query) {
                                $query->with('getProcess');
                            }])
                            ->orderBy('index', 'asc')->get();
                    });


                    $params['curriculum'] = $curriculum;
                    break;
                case "3":
                    $cond = array(
                        array('course', $courseId)
                    );

                    if ($request->questionId) {
                        $cond[] = ['question.id', '=', $request->questionId];
                    }

                    $orderBy = 'desc';
                    $question = $questionRepository->scopeQuery(function ($query) use ($userId, $cond, $orderBy) {
                        return $query->with('getcourse')->with('owner')->with('getAnswer')->where($cond)->orderBy('question.id', $orderBy);

                    })->paginate(5);
                    $params['question'] = $question;
                    $view = 'nqadmin-course::frontend.boughttab3';
                    break;
                case "4":
                    $thongbao = Advertise::where('course_id', $courseId)->get();
                    $params['question'] = $thongbao;
                    $view = 'nqadmin-course::frontend.boughttab4';
                    break;
            }
            if ($view == 'nqadmin-course::frontend.bought') {
                //danh sach cau hoi
                $cond = array(
                    array('course', $courseId)
                );

                $orderBy = 'desc';
                $question = $questionRepository->scopeQuery(function ($query) use ($userId, $cond, $orderBy) {
                    return $query->with('getcourse')->with('owner')->with('getAnswer')->where($cond)->orderBy('question.id', $orderBy);
                })->get();
                $params['questions'] = $question;
                //danh sach cau tra loi

                $thongbao = Advertise::where('course_id', $courseId)->get();
                $params['answers'] = $thongbao;
                //lay so gio hoc
                $duration = DB::table('media')->whereIn('curriculum_item', function ($query) use ($courseId, $userId) {
                    $query->select('id')->from('course_curriculum_items')->where('course_id', $courseId);
                })->sum('duration');
                $params['duration'] = $duration;
            }

            return view($view, $params);
        } else {
            $levelId = $course->getLdp->level;
            if ($levelId) {
                $level = $levelRepository->find($levelId);
            } else {
                $level = '';
            }
            //cac khoa ban chay
            $topAll = $courseRepository->scopeQuery(function ($query) use ($courseId) {
                return $query->with('getLdp')->orderBy('bought', 'asc')->where('status', 'active')->whereNotIn('id', [$courseId])->limit(3);
            })->all();
            //cac khoa lien quan
            $currentClass = $course->getClassLevel()->first();

            if (!empty($currentClass)) {
                $relate = Course::where('status', 'active')->whereNotIn('id', [$courseId])
                    ->whereHas('getLdp', function ($query) use ($currentClass) {
                        $query->where('classlevel', $currentClass->id);
                    })->take(3)->get();
            } else {
                $relate = [];
            }

//            $relate = $courseLdpRepository->with(['getCourse' => function ($query) use ($courseId) {
//                return $query->orderBy('bought', 'desc')->where('id', '!=', $courseId);
//            }])->findWhere([
//                'classlevel' => $classLevel
//            ])->take(3);
//
//            dd($relate);

            //rating
            $cond = array(
                array('course', $courseId)
            );
            $orderBy = 'desc';
            $ratings = $ratingRepository->scopeQuery(function ($query) use ($request, $cond, $orderBy) {
                if ($request->srating)
                    $query = $query->where('content', 'LIKE', '%' . $request->srating . '%');
                return $query->where($cond)->orderBy('id', $orderBy);
            })->with('getcourse')->with('owner')->paginate(5);

            $author = $course->owner()->first();
            $cN = $author->course()->count();

            //lay so gio hoc
            $duration = DB::table('media')->whereIn('curriculum_item', function ($query) use ($courseId) {
                $query->select('id')->from('course_curriculum_items')->where('status', 'active')->where('course_id', $courseId);
            })->sum('duration');

            //lay số học liệu
            $hoclieu = DB::table('media')->where('type', '!=', 'video/mp4')->whereIn('curriculum_item', function ($query) use ($courseId) {
                $query->select('id')->from('course_curriculum_items')->where('status', 'active')->where('course_id', $courseId);
            })->count();
            //lấy số bài trắc nghiệm
            $test = $courseCurriculumItemsRepository->findWhere([
                'course_id' => $courseId,
                'status' => 'active',
                'type' => 'test',
            ])->count();

            return view('nqadmin-course::frontend.index', [
                'course' => $course,
                'level' => $level,
                'c' => $cN,
                'top' => $topAll,
                'ratings' => $ratings,
                'relate' => $relate,
                'duration' => $duration,
                'test' => $test,
                'hoclieu' => $hoclieu
            ]);
        }
    }

    public function postRating(Request $request, RatingRepository $ratingRepository)
    {
        $userId = Auth::id();
        if ($request->rate) {
            $rate = $ratingRepository->updateOrCreate([
                'course' => $request->id,
                'author' => $userId
            ],
                [
                    'content' => isset($request->contentt) ? $request->contentt : '',
                    'rating_number' => $request->rate,
                ]);
        }
        return back();
    }

    public function ajaxPostSearchComment(Request $request, RatingRepository $ratingRepository)
    {
        if ($request->ajax()) {
            $keywords = $request->get('keywords');
            $cid = $request->get('cid');

            $result = $ratingRepository->orderBy('created_at', 'desc')
                ->findWhere([
                    ['content', 'LIKE', '%' . $keywords . '%'],
                    'course' => $cid
                ]);

            $view = view('nqadmin-course::frontend.ratingsearchajax', [
                'ratings' => $result
            ])->render();

            return response()->json([
                'data' => $view
            ]);
        }
    }
}