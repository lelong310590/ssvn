<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/8/2018
 * Time: 12:15 AM
 */

namespace Course\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Course\Repositories\CourseRepository;
use Course\Repositories\CourseTargetRepository;
use Illuminate\Http\Request;
use Base\Supports\FlashMessage;
use DebugBar;

class CourseTargetController extends BaseController
{
	protected $repository;
	
	public function __construct(CourseTargetRepository $courseLdpRepository)
	{
		$this->repository = $courseLdpRepository;
	}
	
	/**
	 * @param                                       $id
	 * @param \Course\Repositories\CourseRepository $courseRepository
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getIndex($id, CourseRepository $courseRepository)
	{
		$course = $courseRepository->find($id);
		$target = $this->repository->findWhere(['course_id' => $id], ['target'])->first();
		return view('nqadmin-course::backend.coursetarget.index', [
			'course' => $course,
			'target' => $target
		]);
	}
	
	/**
	 * @param \Illuminate\Http\Request $request
	 */
	public function postIndex(Request $request)
	{
		try {
			$target = $request->except(['_token', 'course_id']);
			$this->repository->updateOrCreate([
				'course_id' => $request->get('course_id')
			], ['target' => $target]);
			
			return redirect()->back()->with(FlashMessage::returnMessage('edit'));
		} catch (\Exception $e) {
			Debugbar::addThrowable($e->getMessage());
			return redirect()->back()->withErrors(config('messages.error'));
		}
	}
}