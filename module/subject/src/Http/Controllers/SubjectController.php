<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 5:47 PM
 */

namespace Subject\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use ClassLevel\Repositories\ClassLevelRepository;
use Subject\Http\Requests\EditSubjectRequest;
use Subject\Repositories\SubjectRepository;
use Base\Supports\FlashMessage;
use Subject\Http\Requests\CreateSubjectRequest;
use DebugBar;

class SubjectController extends BaseController
{
	protected $repository;
	
	public function __construct(SubjectRepository $subjectRepository)
	{
		$this->repository = $subjectRepository;
	}
	
	/**
	 * @param \ClassLevel\Repositories\ClassLevelRepository $classLevelRepository
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getIndex(ClassLevelRepository $classLevelRepository)
	{
		$data = $this->repository->orderBy('created_at', 'desc')->all();
		$class = $classLevelRepository->orderBy('created_at', 'desc')->all();
		return view('nqadmin-subject::backend.index', [
			'data' => $data,
			'classLevel' => $class
		]);
	}
	
	/**
	 * @param \Subject\Http\Requests\CreateSubjectRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function postCreate(CreateSubjectRequest $request)
	{
		try {
			$input = $request->except('_token', 'subject');
			$subject = $this->repository->create($input);
			if (!empty($request->subject)) {
				$this->repository->sync($subject->id, 'classLevel', $request->subject);
			}
			
			return redirect()->back()->with(FlashMessage::returnMessage('create'));
		} catch (\Exception $e) {
			return redirect()->back()->withErrors(config('messages.error'));
		}
	}
	
	/**
	 * @param                                               $id
	 * @param \ClassLevel\Repositories\ClassLevelRepository $classLevelRepository
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getEdit($id, ClassLevelRepository $classLevelRepository)
	{
		$data = $this->repository->find($id);
		$classSelected = $data->classLevel()->get();
		$selected = [];
		foreach ($classSelected as $s) {
			$selected[] = $s->id;
		}
		$class = $classLevelRepository->orderBy('created_at', 'desc')->all();
		return view('nqadmin-subject::backend.edit', [
			'data' => $data,
			'classLevel' => $class,
			'selected' => $selected
		]);
	}
	
	/**
	 * @param                                           $id
	 * @param \Subject\Http\Requests\EditSubjectRequest $request
	 *
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function postEdit($id, EditSubjectRequest $request)
	{
		try {
			$input = $request->except(['_token', 'current_id', 'subject']);
			$this->repository->update($input, $id);
			$subject = $request->get('subject');
            $this->repository->sync($id, 'classLevel', $subject);

			return redirect()->back()->with(FlashMessage::returnMessage('edit'));
		} catch (\Exception $e) {
			return redirect()->back()->withErrors(config('messages.error'));
		}
	}
	
	/**
	 * @param $id
	 *
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function getDelete($id)
	{
		return getDelete($id, $this->repository);
	}
	
}