<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 5/15/2018
 * Time: 9:33 PM
 */

namespace Course\Http\Controllers\Frontend;

use Barryvdh\Debugbar\Controllers\BaseController;
use Course\Http\Requests\CreateCourseLandingPageRequest;
use Course\Http\Requests\CreateCourseRequest;
use Course\Repositories\CourseLdpRepository;
use Course\Models\CourseCurriculumItems;
use Course\Models\TestResult;
use Course\Repositories\CourseRepository;
use Course\Models\CurriculumProgress;
use Media\Repositories\MediaRepository;
use Subject\Repositories\SubjectRepository;
use ClassLevel\Repositories\ClassLevelRepository;
use Level\Repositories\LevelRepository;
use Auth;
use Tag\Repositories\TagRepository;
use Base\Supports\FlashMessage;

class CourseController extends BaseController
{
    protected $course;
    protected $courseldp;

    public function __construct(CourseRepository $courseRepository, CourseLdpRepository $courseLdpRepository)
    {
        $this->course = $courseRepository;
        $this->courseldp = $courseLdpRepository;
    }

    public function createCourse()
    {
        return view('nqadmin-course::frontend.course.create');
    }

    /**
     * @param CreateCourseRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCraeteCourse(CreateCourseRequest $request)
    {
        try {
            $input = $request->except('_token');
            $course = $this->course->create($input);
            return redirect()->route('front.khoahoclandingpage', [$course->id]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(config('messages.error'));
        }
    }

    public function resetProgress($id)
    {
        $userId = Auth::id();
        $items = CurriculumProgress::where('course_id', $id)->where('student', Auth::id())->get();
//            ->update(['progress' => 0, 'status' => 3]);
        //xoa result
        foreach ($items as $item) {
            $tests = TestResult::where('owner', $userId)->where('lecture_id', $item->curriculum_id)->get();
            foreach ($tests as $test) {
                $test->forceDelete();
            }
            $item->forceDelete();
        }
        CourseCurriculumItems::where('course_id', $id)->where('type', '!=', 'section')->first()->updateLastCurriculum();
        return back();
    }

    /**
     * @param SubjectRepository $subjectRepository
     * @param ClassLevelRepository $classLevelRepository
     * @param LevelRepository $levelRepository
     * @param CourseRepository $courseRepository
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function khoahoclandingpage(
        SubjectRepository $subjectRepository,
        ClassLevelRepository $classLevelRepository,
        LevelRepository $levelRepository,
        CourseRepository $courseRepository,
        $id
    )
    {
        $course = $courseRepository->find($id);
        $subjects = $subjectRepository->orderBy('created_at', 'desc')->all();
        $classLevels = $classLevelRepository->orderBy('created_at', 'desc')->all();
        $level = $levelRepository->orderBy('created_at', 'desc')->all();

        $ldp = $this->courseldp->findWhere([
            'course_id' => $id
        ])->first();
        $tagVal = array();
        if ($ldp) {
            $tags = $ldp->getTag()->get();
            foreach ($tags as $tag) {
                $tagVal[] = $tag->name;
            }
        }
        return view('nqadmin-course::frontend.course.courseldp.index', [
            'subjects' => $subjects,
            'classLevels' => $classLevels,
            'level' => $level,
            'course' => $course,
            'ldp' => $ldp,
            'tags' => $tagVal
        ]);
    }

    public function postkhoahoclandingpage(
        $id,
        CreateCourseLandingPageRequest $request,
        CourseRepository $courseRepository,
        MediaRepository $mediaRepository,
        TagRepository $tagRepository
    )
    {
        try {
            /**
             * Update in course table
             */
            $course = $request->only(['name', 'slug']);
            $courseRepository->update($course, $id);

            /**
             * Update in course_ldp table
             */
            $userId = Auth::id();

            $tagId = array();
            if (isset($request->tags) && !empty($request->tags)) {
                $tags = explode(',', $request->tags);
                foreach ($tags as $tag) {
                    $check = $tagRepository->findByField('name', $tag);
                    if ($check->isEmpty()) {
                        $t = $tagRepository->create([
                            'name' => $tag,
                            'slug' => $tag,
                            'author' => $userId
                        ]);
                    } else {
                        $t = $check->first();
                    }
                    array_push($tagId, $t->id);
                }
            }

            $ldp = $request->except(['_token', 'name', 'slug', 'tags', 'course_id']);
            //upload image
            if ($request->file('thumbnail')) {
                $urlImage = $mediaRepository->uploadImage($userId, $request->file('thumbnail'));
                $ldp['thumbnail'] = $urlImage;
            }
            //upload video
            if ($request->file('video_promo')) {
                $video = $mediaRepository->uploadVideo($userId, $request->file('video_promo'));
                $ldp['video_promo'] = $video;
            }

            $course = $this->courseldp->updateOrCreate([
                'course_id' => $request->get('course_id')
            ], $ldp);

//            $course->getTag()->sync([5,6,7]);
            $course->getTag()->sync($tagId);

            return redirect()->back()->with(FlashMessage::returnMessage('edit'));

        } catch (\Exception $e) {
            return $e->getMessage();
            //return redirect()->back()->withErrors(config('messages.error'));
        }

    }
}