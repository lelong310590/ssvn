<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 12:15 AM
 */

namespace Base\Http\Controllers\    Frontend;

use Barryvdh\Debugbar\Controllers\BaseController;
use Carbon\Carbon;
use ClassLevel\Models\ClassLevel;
use ClassLevel\Repositories\ClassLevelRepository;
use Course\Models\Course;
use Course\Models\TestResult;
use Course\Repositories\CourseLdpRepository;
use Course\Repositories\CourseRepository;
use Course\Repositories\TestResultRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use MultipleChoices\Models\Answer;
use MultipleChoices\Models\Question;
use MultipleChoices\Repositories\QuestionRepository;
use Subject\Models\Subject;
use Users\Models\Users;
use Users\Repositories\UsersRepository;
use Level\Repositories\LevelRepository;
use Illuminate\Http\Request;
use Course\Repositories\CourseCurriculumItemsRepository;
use MultipleChoices\Repositories\AnswerRepository;
use Cache;

class HomeController extends BaseController
{
    public function getIndex(
        CourseRepository $courseRepository,
        UsersRepository $usersRepository,
        LevelRepository $levelRepository,
        ClassLevelRepository $classLevelRepository
    )
    {
        //top Trac nghiem
        $topCheck = $topAll = $courseRepository->scopeQuery(function ($query) {
            return $query->select('slug', 'name', 'price', 'id')->where('status', 'active')->where('type', 'test')->orderBy('created_at', 'desc')->take(6);
        })->with('getRating')->with(['getLdp' => function ($q) {
            return $q->with('getClassLevel')->with('getSubject')->get();
        }])->get();

        $currentCompany = false;

        //moi nhat
        if (auth('nqadmin')->check()) {
            $classLevel = auth('nqadmin')->user();
            $currentCompany = $classLevelRepository->find($classLevel)->first();
            $topNews = $courseRepository->scopeQuery(function ($query) {
                return $query->select('slug', 'name', 'price', 'id')
                    ->where('status', 'active')
                    ->orderBy('created_at', 'desc')
                    ->take(12);
            })
            ->whereHas('getClassLevel', function ($q) use ($classLevel) {
                $q->where('classlevel.id', $classLevel->classlevel);
            })->orWhereHas('getClassLevel', function($or) {
                $or->where('course_ldp.classlevel', null);
            })
            ->with('getRating')
            ->with(['getLdp' => function ($q) {
                return $q->with('getClassLevel')->with('getSubject')->get();
            }])

            ->get();

        } else {
            $topNews = $courseRepository->scopeQuery(function ($query) {
                return $query->select('slug', 'name', 'price', 'id')
                    ->where('status', 'active')
                    ->orderBy('created_at', 'desc')
                    ->take(12);
            })
                ->with('getRating')
                ->with(['getLdp' => function ($q) {
                    return $q->with('getClassLevel')->with('getSubject')->get();
                }])
                ->get();
        }

        //duoc mua nhieu nhat
        $topAll = $courseRepository->scopeQuery(function ($query) {
            return $query->select('slug', 'name', 'price', 'id')->where('status', 'active')
                ->where('type', '!=', 'test')->where('type', '!=', 'exam')->orderBy('bought', 'desc')->take(12);
        })->with('getRating')->with(['getLdp' => function ($q) {
            return $q->with('getClassLevel')->with('getSubject')->get();
        }])->get();

        //top khoa hoc thuong
        $topCourse = $courseRepository->scopeQuery(function ($query) {
            return $query->select('slug', 'name', 'price', 'id')->where('status', 'active')
                ->where('type', '!=', 'test')->where('type', 'normal')->orderBy('created_at', 'desc')->take(12);
        })->with('getRating')->with(['getLdp' => function ($q) {
            return $q->with('getClassLevel')->with('getSubject')->get();
        }])->get();


//        //top trac nghiem mon ly
//        $top1 = $courseRepository->scopeQuery(function ($query) {
//            return $query->select('slug', 'name', 'price', 'id')->whereHas('getLdp', function ($query) {
//                return $query->where('subject', '5');
//            })->where('status', 'active')->orderBy('bought', 'desc')->take(6);
//        })->with('getRating')->with('getLdp')->get();

        //top giao vien
        $topTeachers = $usersRepository->scopeQuery(function ($query) {
            return $query->select('id', 'thumbnail', 'first_name', 'last_name')->where('status', 'active')
                ->where('position', 'giao_vien')
                ->orderBy('sold_course', 'desc')
                ->take(6);
        })->all();

        //trinh do
        $level = Cache::remember('level', 60 * 60 * 24, function () use ($levelRepository) {
            return $levelRepository->scopeQuery(function ($query) {
                return $query->select('thumbnail', 'name', 'slug')->take(4);
            })->all();
        });

        return view('nqadmin-dashboard::frontend.index', compact(
            'topAll', 'topCheck', 'topCourse', 'topNews', 'topTeachers',
            'level', 'currentCompany'
        ));
    }

    public function loadquickview(Request $request, CourseRepository $courseRepository,
                                  ClassLevelRepository $classLevelRepository,
                                  CourseCurriculumItemsRepository $courseCurriculumItemsRepository)
    {
        if ($request->ajax()) {
            $course = $courseRepository->with('owner')->with('getLdp')->find($request->course_id);
            $classlevel = $classLevelRepository->find($course->getLdp->classlevel);
            $curItem = $courseCurriculumItemsRepository->findWhere([
                'course_id' => $request->course_id,
                'type' => 'lecture'
            ])->count();
            $returnHTML = view('nqadmin-dashboard::frontend.quickview',
                [
                    'course' => $course,
                    'classlevel' => $classlevel,
                    'curItem' => $curItem
                ])->render();
            return response()->json(['html' => $returnHTML]);
        }

    }

    public function searchsuggest(Request $request, CourseRepository $courseRepository)
    {
        $course = Course::getFilter('search', $request);
        $returnHTML = '';
        if (count($course) > 0) {
            $returnHTML = view('nqadmin-dashboard::frontend.components.header.autosearch',
                [
                    'course' => $course,
                    'q' => $request->q
                ])->render();
        }
        return response()->json(['html' => $returnHTML]);
    }

    public function search(Request $request, CourseRepository $courseRepository, CourseLdpRepository $courseLdpRepository)
    {
        $subjects = Subject::all();
        $classlevels = ClassLevel::all();
        if ($request->q) {
            $course = Course::getFilter('search', $request);
            if ($request->ajax()) {
                $html = view('nqadmin-course::frontend.components.main-course-search', ['course' => $course])->render();
                return json_encode(['html' => $html]);
            }
            return view('nqadmin-dashboard::frontend.search_result', [
                'course' => $course,
                'subjects' => $subjects,
                'classlevels' => $classlevels,
            ]);
        } else if ($request->get('filter')) {
            $filter = $request->get('filter');
            $course = [];
            switch ($filter) {
                case 'mostview':
                    if ($request->key && $request->order) {
                        $course = $courseRepository->scopeQuery(function ($q) use ($request) {
                            return $q->orderBy($request->get('key'), $request->get('order'))->where('status', 'active');
                        })->paginate(20);
                    } else {
                        $course = $courseRepository->scopeQuery(function ($q) {
                            return $q->orderBy('bought', 'desc')->where('status', 'active');
                        })->paginate(20);
                    }

                    break;
                case 'level4':
                    $course = $this->filterCourse('1');
                    break;
                case 'level3':
                    $course = $this->filterCourse('3');
                    break;
                case 'level2':
                    $course = $this->filterCourse('4');
                    break;
                case 'level1':
                    $course = $this->filterCourse('5');
                    break;
                default:
                    return $course;
            }

            if ($filter == 'mostview') {
                $convert = $course;
            } else {
                if ($request->key && $request->order) {
                    $convert = $courseRepository->scopeQuery(function ($q) use ($course, $request) {
                        return $q->orderBy($request->get('key'), $request->get('order'))->whereIn('id', $course);
                    })->paginate(20);
                } else {
                    $convert = $courseRepository->scopeQuery(function ($q) use ($course) {
                        return $q->whereIn('id', $course);
                    })->paginate(20);
                }
            }

            return view('nqadmin-dashboard::frontend.search_result', [
                'course' => $convert,
            ]);

        } else {
            $course = Course::getFilter('list', $request);
            if ($request->ajax()) {
                $html = view('nqadmin-subject::frontend.main', ['course' => $course])->render();
                return json_encode(['html' => $html]);
            }
            return redirect(route('front.home.index.get'));
        }
    }

    /**
     * @param $level
     * @return array
     */
    public function filterCourse($subjectId)
    {
        $newCourse = [];
        $course = DB::table('course_ldp')
            ->leftJoin('classlevel', 'course_ldp.classlevel', '=', 'classlevel.id')
            ->leftJoin('course', 'course_ldp.course_id', '=', 'course.id')
            ->orderBy('classlevel.name', 'asc')
            ->select('course.id')
            ->where([
                ['course_ldp.subject', '=', $subjectId],
                ['course.status', '=', 'active']
            ])
            ->get()
            ->toArray();

        foreach ($course as $c) {
            $newCourse[] = $c->id;
        }

        return $newCourse;
    }

    public function trothanhgiaovien()
    {
        return view('nqadmin-dashboard::frontend.trothanhgiaovien');
    }

    function convert($content, $key)
    {
        $carbon = new Carbon;
        $year = $carbon->now()->year;
        $month = $carbon->now()->month;
        $patterns = [
            '/src=\"([^\s]*)\" alt/',
            '/src=\"([^\s]*)\" width/',
        ];
        foreach ($patterns as $pattern) {
            preg_match_all($pattern, $content, $img);
            if (!empty($img)) {
                foreach ($img[1] as $item) {
                    $data = str_replace('data:image/png;base64,', '', $item);
                    $data = str_replace(' ', '+', $data);
                    $data = base64_decode($data);
                    $fileName = 'upload/quiz_source/' . $year . '/' . $month . '/' . time() . $key . '.png';
                    $url = 'https://video.anticovid.com/' . $fileName;
                    $content = str_replace($item, $url, $content);
                    file_put_contents($fileName, $data);
                }
            }
        }
        return $content;
    }

    function convert2($content, $key)
    {
        $carbon = new Carbon;
        $year = $carbon->now()->year;
        $month = $carbon->now()->month;
        $patterns = [
            '/src=\\\"([^\s]*)\" alt/',
            '/src=\\\"([^\s]*)\" width/',
        ];
        foreach ($patterns as $pattern) {
            preg_match_all($pattern, $content, $img);
            if (!empty($img)) {
                foreach ($img[1] as $item) {
                    $data = str_replace('data:image/png;base64,', '', $item);
                    $data = str_replace(' ', '+', $data);
                    $data = base64_decode($data);
                    $fileName = 'upload/quiz_source/' . $year . '/' . $month . '/' . time() . $key . '.png';
                    $url = 'https://video.anticovid.com/' . $fileName;
                    $content = str_replace($item, $url, $content);
                    file_put_contents($fileName, $data);
                }
            }
        }
        return $content;
    }

    function convert3($content, $key)
    {
        $carbon = new Carbon;
        $year = $carbon->now()->year;
        $month = $carbon->now()->month;
        $patterns = [
            '/src=\\\\\\\"([^\s]*)\" alt/',
            '/src=\\\\\\\"([^\s]*)\" width/',
        ];
        foreach ($patterns as $pattern) {
            preg_match_all($pattern, $content, $img);
            if (!empty($img)) {
                foreach ($img[1] as $item) {
                    $data = str_replace('data:image/png;base64,', '', $item);
                    $data = str_replace(' ', '+', $data);
                    $data = base64_decode($data);
                    $fileName = 'upload/quiz_source/' . $year . '/' . $month . '/' . time() . $key . '.png';
                    $url = 'https://video.anticovid.com/' . $fileName;
                    $content = str_replace($item, $url, $content);
                    file_put_contents($fileName, $data);
                }
            }
        }
        dump($content);
        dd($img);
        return $content;
    }

    public function updateQuestion(QuestionRepository $questionRepository)
    {
        ini_set('memory_limit', '-1');
        try {

            $questions = $questionRepository->scopeQuery(function ($q) {
                return $q->where('content', 'LIKE', '%data:image/png;base64%');
            })->all();

            foreach ($questions as $key => $question) {
                $content = $this->convert($question->content, $key);
                $temp = Question::find($question->id);
                $temp->content = $content;
                $temp->save();
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateQuestionReason(QuestionRepository $questionRepository)
    {
        ini_set('memory_limit', '-1');
        try {

            $questions = $questionRepository->scopeQuery(function ($q) {
                return $q->where('reason', 'LIKE', '%data:image/png;base64%');
            })->all();

            foreach ($questions as $key => $question) {
                $content = $this->convert($question->reason, $key);
                $temp = Question::find($question->id);
                $temp->reason = $content;
                $temp->save();
            }

            return 'complete';


        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateAnswer(AnswerRepository $answerRepository)
    {
        ini_set('memory_limit', '-1');
        try {

            $questions = $answerRepository->scopeQuery(function ($q) {
                return $q->where('content', 'LIKE', '%data:image/png;base64%');
            })->all();


            foreach ($questions as $key => $question) {
                $content = $this->convert($question->content, $key);
                $temp = Answer::find($question->id);
                $temp->content = $content;
                $temp->save();
            }

            return 'complete';


        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateResult(TestResultRepository $testResultRepository)
    {
        ini_set('memory_limit', '-1');
        try {

            $questions = $testResultRepository->scopeQuery(function ($q) {
                return $q->where('question', 'LIKE', '%base64%');
            })->all();

            foreach ($questions as $key => $question) {
                $content = $this->convert2($question->question, $key);
                $temp = TestResult::find($question->id);
                $temp->question = $content;
                $temp->save();
            }

            return 'complete';


        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param TestResultRepository $testResultRepository
     * @return string
     */
    public function updateResultDetail(TestResultRepository $testResultRepository)
    {
        ini_set('memory_limit', '-1');
        try {

            $questions = $testResultRepository->with(['lecture' => function ($l) {
                return $l->select('id')->with(['getAllQuestion' => function ($q) {
                    return $q->select('id', 'curriculum_item');
                }]);
            }])->all(['id', 'detail', 'lecture_id']);

            foreach ($questions as $q) {
                $numberQuestion = $q->lecture->getAllQuestion->count() * 4;

                $detail = json_decode(json_decode($q->detail));

                foreach ($detail as $key => $answer) {
                    if ($key > ($numberQuestion - 1)) {
                        unset($detail[$key]);
                    }
                }

                $newDetail = json_encode(json_encode($detail));

                $testResultRepository->update([
                    'detail' => $newDetail
                ], $q->id);
            }

            return 'complete';


        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    function updatePosition()
    {
        $users = Users::all();
        foreach ($users as $user) {
            $position = $user->getDataRawByKey('position');
            $user->position = $position;
            $user->save();
        }
    }

    function checkRemoteFile($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        // don't download content
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        curl_close($ch);
        if ($result !== FALSE) {
            return true;
        } else {
            return false;
        }
    }

    public function checkQuestion(QuestionRepository $questionRepository)
    {
        ini_set('memory_limit', '-1');
        try {
            $questions = Question::where('content', 'LIKE', '%img src%')->get();
            foreach ($questions as $key => $question) {
                $content = $question->content;
                $patterns = [
                    '/src=\"([^\s]*)\" alt/',
                    '/src=\"([^\s]*)\" width/',
                ];
                foreach ($patterns as $pattern) {
                    preg_match_all($pattern, $content, $img);
                    if (!empty($img)) {
                        foreach ($img[1] as $item) {
                            try {
                                list($width, $height) = getimagesize($item);
                                if (empty($height) || empty($width)) {
                                    \Log::alert('Question id: ' . $question->id . ' content: ' . $content);
                                }
                            } catch (\Exception $e) {
                            }
                        }
                    }
                }
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}