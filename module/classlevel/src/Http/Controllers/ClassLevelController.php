<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 10:22 AM
 */

namespace ClassLevel\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use ClassLevel\Http\Requests\EditClassLevelRequest;
use ClassLevel\Repositories\ClassLevelRepository;
use Base\Supports\FlashMessage;
use DebugBar;
use ClassLevel\Http\Requests\CreateClassLevelRequest;

class ClassLevelController extends BaseController
{
	protected $repository;
	
	public function __construct(ClassLevelRepository $classLevel)
	{
		$this->repository = $classLevel;
	}
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getIndex()
	{
		$data = $this->repository->all();
		return view('nqadmin-classlevel::backend.index', [
			'data' => $data
		]);
	}
	
	/**
	 * @param \ClassLevel\Http\Requests\CreateClassLevelRequest $request
	 *
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function postCreate(CreateClassLevelRequest $request)
	{
		try {
			$input = $request->except('_token');
			$this->repository->create($input);
			return redirect()->back()->with(FlashMessage::returnMessage('create'));
		} catch (\Exception $e) {
			Debugbar::addThrowable($e->getMessage());
			return redirect()->back()->withErrors(config('messages.error'));
		}
	}
	
	/**
	 * @param $id
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getEdit($id)
	{
		$classLevel = $this->repository->with(['owner', 'edit'])->find($id);
		return view('nqadmin-classlevel::backend.edit', [
			'data' => $classLevel,
		]);
	}
	
	/**
	 * @param                                                 $id
	 * @param \ClassLevel\Http\Requests\EditClassLevelRequest $request
	 *
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function postEdit($id, EditClassLevelRequest $request)
	{
		try {
			$input = $request->except(['_token', 'current_id']);
			$this->repository->update($input, $id);
			return redirect()->back()->with(FlashMessage::returnMessage('edit'));
			
		} catch (\Exception $e) {
			Debugbar::addThrowable($e->getMessage());
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
	
	/**
	 * @param $id
	 *
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function changeStatus($id)
	{
		return changeStatus($id, $this->repository);
	}
}