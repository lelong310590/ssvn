<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 5/11/2018
 * Time: 2:57 PM
 */

namespace Course\Http\Controllers\Frontend;

use Barryvdh\Debugbar\Controllers\BaseController;
use Course\Repositories\CourseCurriculumItemsRepository;
use Course\Repositories\CourseRepository;
use Illuminate\Http\Request;

class LectureController extends BaseController
{
    protected $course;
    protected $lecture;

    public function __construct(
        CourseRepository $courseRepository,
        CourseCurriculumItemsRepository $courseCurriculumItemsRepository
    )
    {
        $this->course = $courseRepository;
        $this->lecture = $courseCurriculumItemsRepository;
    }

    public function getIndex($slug, $lectureId = null, $type = null, $status = null, Request $request)
    {
        $course = $this->course->findWhere(['slug' => $slug])->first();
        if ($lectureId) {
            $lecture = $this->lecture->find($lectureId);
        } else {
            $lecture = $course->getCurriculum->first();
        }
        if ($lecture->type == 'section') {
            $lecture = $lecture->getChildCurriculum->first();
        }
        return view('nqadmin-course::frontend.lecture.video', [
            'course' => $course,
            'lecture' => $lecture,
            'type' => $type,
            'status' => $status
        ]);
    }

}