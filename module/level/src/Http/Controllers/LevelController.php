<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/6/2018
 * Time: 11:33 PM
 */

namespace Level\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Level\Http\Requests\CreateLevelRequest;
use Level\Http\Requests\EditLevelRequest;
use Level\Repositories\LevelRepository;
use Base\Supports\FlashMessage;
use DebugBar;

class LevelController extends BaseController
{
	protected $repository;
	
	public function __construct(LevelRepository $levelRepository)
	{
		$this->repository = $levelRepository;
	}
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getIndex()
	{
		$data = $this->repository->all();
		return view('nqadmin-level::backend.index', [
			'data' => $data
		]);
	}
	
	/**
	 * @param \Level\Http\Requests\CreateLevelRequest $request
	 *
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function postCreate(CreateLevelRequest $request)
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
		$data = $this->repository->with(['owner', 'edit'])->find($id);
		return view('nqadmin-level::backend.edit', [
			'data' => $data,
		]);
	}
	
	/**
	 * @param                                       $id
	 * @param \Level\Http\Requests\EditLevelRequest $request
	 *
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function postEdit($id, EditLevelRequest $request)
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
	public function setFeatured($id)
	{
		return setFeatured($id, $this->repository);
	}
}