<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/9/2018
 * Time: 4:08 PM
 */

namespace Course\Http\Controllers;

use Course\Repositories\CourseRepository;
use Barryvdh\Debugbar\Controllers\BaseController;
use Base\Supports\FlashMessage;

class CourseCurriculumController extends BaseController
{
	public function getIndex($id, CourseRepository $courseRepository)
	{
		$course = $courseRepository->find($id);
		return view('nqadmin-course::backend.coursecurriculum.index', [
			'course' => $course
		]);
	}

	public function postIndex($id)
    {
        return redirect()->back()->with(FlashMessage::returnMessage('edit'));
    }
}