<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/9/2018
 * Time: 3:14 PM
 */

namespace PriceTier\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use PriceTier\Http\Requests\CreatePriceTierRequest;
use PriceTier\Http\Requests\EditPriceTierRequest;
use PriceTier\Repositories\PriceTierRepository;
use Base\Supports\FlashMessage;
use DebugBar;

class PriceTierController extends BaseController
{
	protected $repository;
	
	public function __construct(PriceTierRepository $priceTierRepository)
	{
		$this->repository = $priceTierRepository;
	}
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getIndex()
	{
		$data = $this->repository->all();
		return view('nqadmin-pricetier::backend.index', [
			'data' => $data
		]);
	}
	
	/**
	 * @param \PriceTier\Http\Requests\CreatePriceTierRequest $request
	 *
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function postCreate(CreatePriceTierRequest $request)
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
		return view('nqadmin-pricetier::backend.edit', [
			'data' => $classLevel,
		]);
	}
	
	/**
	 * @param                                               $id
	 * @param \PriceTier\Http\Requests\EditPriceTierRequest $request
	 *
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function postEdit($id, EditPriceTierRequest $request)
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