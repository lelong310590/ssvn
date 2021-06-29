<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/6/2018
 * Time: 1:44 PM
 */

namespace Course\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Course\Http\Requests\CreateCourseRequest;
use Base\Supports\FlashMessage;
use Course\Models\Course;
use Course\Repositories\CourseCurriculumItemsRepository;
use Course\Repositories\CourseLdpRepository;
use Course\Repositories\CourseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PriceTier\Repositories\PriceTierRepository;
use Cache;

class CourseController extends BaseController
{
    protected $repository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->repository = $courseRepository;
    }

    public function getSetting()
    {
        return view('nqadmin-course::backend.setting');
    }

    public function getIndex(Request $request)
    {
        if($request->get('name')){
            $name = $request->get('name');
            $data = $this->repository->with('getLdp')->scopeQuery(function($e) use($name){
                return $e->where('name','LIKE',"%$name%");
            })->paginate(10);
        }else {
            $data = $this->repository->getCourseInIndex();
        }
        return view('nqadmin-course::backend.index', [
            'data' => $data
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate()
    {
        return view('nqadmin-course::backend.create');
    }

    /**
     * @param \Course\Http\Requests\CreateCourseRequest $request
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postCreate(
        CreateCourseRequest $request, PriceTierRepository $priceTierRepository,
        CourseCurriculumItemsRepository $courseCurriculumItemsRepository,
        CourseLdpRepository $courseLdpRepository
    )
    {
        try {
            $price = $priceTierRepository->orderBy('price', 'asc')->first(['price']);
            $input = $request->except('_token');

            if (!empty($price)) {
                $input = $request->merge([
                    'price' => $price->price
                ])->except('_token');
            }

            $course = $this->repository->create($input);
            if ($course->type == 'test') {
                $courseCurriculumItemsRepository->createSectionForTest($course, 'Bài trắc nghiệm');
            }

            if ($course->type == 'exam') {
                $courseCurriculumItemsRepository->createSectionForTest($course, 'Bài thi thử');
            }

            $courseLdpRepository->create(['course_id' => $course->id]);

            return redirect()->route('nqadmin::course.landingpage.get', [$course->id]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(config('messages.error'));
        }
    }

    public function getDelete($id)
    {
        try {
            $course = DB::table('course')->find($id);
            $orderDetail = DB::table('order_details')->where('course_id', '=', $course->id)
                ->first();
            if (!empty($orderDetail)) {
                DB::table('order_details')->delete($orderDetail->id);
//                DB::table('orders')->delete($orderDetail->order_id);
            }
            DB::table('curriculum_progress')->where('course_id', '=', $course->id)->delete();
            DB::table('coupon')->where('course', '=', $course->id)->delete();
            DB::table('rating')->where('course', '=', $course->id)->delete();
            DB::table('course_target')->where('course_id', '=', $course->id)->delete();
            DB::table('course_ldp')->where('course_id', '=', $course->id)->delete();
            $question = DB::table('question')->where('course', '=', $course->id)->get();

            if (!empty($question)) {
                foreach ($question as $q) {
                    DB::table('answer')->where('question', '=', $q->id)->delete();
                }
                DB::table('question')->where('course', '=', $course->id)->delete();
            }

            $courseCurriculum = DB::table('course_curriculum_items')->where('course_id', '=', $course->id)->get();

            if (!empty($courseCurriculum)) {
                foreach ($courseCurriculum as $curriculum) {
                    DB::table('media')->where('curriculum_item', '=', $curriculum->id)
                        ->update(['curriculum_item' => null]);
                    $questions = DB::table('questions')->where('curriculum_item', '=', $curriculum->id)->get();
                    if (!empty($questions)) {
                        foreach ($questions as $ques) {
                            DB::table('answers')->where('question', '=', $ques->id)->delete();
                        }

                        DB::table('questions')->where('curriculum_item', '=', $curriculum->id)->delete();
                    }
                }

                DB::table('course_curriculum_items')->where('course_id', '=', $course->id)->delete();
            }

            DB::table('course')->delete($id);

            return redirect()->back()->with(FlashMessage::returnMessage('delete'));

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEnable($id)
    {
        $course = $this->repository->find($id);
        $users = DB::table('users_metas')->join('users', 'users_metas.users_id', '=', 'users.id')
            ->select('users.id', 'users.email', 'users.first_name', 'users.last_name')
            ->where([
            ['users.position', '=', 'giao_vien'],
            ['users.status', '=', 'active']
        ])->get();
        return view('nqadmin-course::backend.enable', ['course' => $course, 'users' => $users]);
    }


    public function changeAuthor($id, Request $request)
    {
        $user = $request->get('author');
        $this->repository->update(['author' => intval($user)], $id);
        return redirect()->back()->with(FlashMessage::returnMessage('edit'));
    }

    public function changeAssistant($id, Request $request)
    {
        $user = $request->get('assistant');
        $this->repository->update(['assistant' => intval($user)], $id);
        return redirect()->back()->with(FlashMessage::returnMessage('edit'));
    }

    public function postEnable($id)
    {
        $course = $this->repository->find($id);
        //Check giá
        $price = $course->price;
        $status = $course->status;
        $allCurriculum = $course->getCurriculum()->where('status', 'active')->get();
        $section = $course->getCurriculum()->where('status', 'active')->where('type', '=', 'section')->get();

        if ($status == 'disable') {
            if ($allCurriculum->isEmpty()) {
                $mess = '';
                if ($allCurriculum->isEmpty() || $section->isEmpty()) {
                    $mess .= ' - Kiểm tra lại các bài học trong Khóa đào tạo- Mỗi bài học phải bắt buộc phải thuộc một phần';
                }
                return redirect()->back()->withErrors($mess);
            }
        }

        $this->repository->update(['status' => $course->status == 'active' ? 'disable' : 'active'], $id);

        return back()->with('Duyệt Khóa đào tạothành công');
    }

    public function getEnableList()
    {
        $data = $this->repository
            ->with('getLdp')
            ->orderBy('created_at', 'desc')
            ->findWhere(['status' => 'disable']);
        return view('nqadmin-course::backend.listenable', [
            'data' => $data
        ]);
    }

    public function enableAll()
    {
        $res = Course::where('status', 'disable')->update(['status' => 'active']);
        return back()->with('Thành công');
    }

    public function googleAnalytics($id)
    {
        $course = $this->repository->find($id);
        return view('nqadmin-course::backend.coursega.index', [
            'course' => $course
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function postgoogleAnalytics($id, Request $request)
    {
        $ga = $request->get('google_analytics_id');
        $this->repository->update([
            'google_analytics_id' => $ga
        ], $id);

        return back()->with(FlashMessage::renderMessage('edit'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getExamSetting($id)
    {
        $course = $this->repository->find($id);
        return view('nqadmin-course::backend.courseexam.index', [
            'course' => $course
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function postExamSetting($id, Request $request)
    {
        $timeStart = $request->get('time_start');
        $timeEnd = $request->get('time_end');
        $slug = $request->get('slug');
        $this->repository->update([
            'time_start' => $timeStart,
            'time_end' => $timeEnd
        ], $id);

        Cache::forget('singleCourse-'.$slug);

        return back()->with(FlashMessage::renderMessage('edit'));
    }
}