<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 10:22 AM
 */

namespace ClassLevel\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Base\Jobs\SendMail;
use Base\Mail\CreateUserWhenCreateCompany;
use Carbon\Carbon;
use ClassLevel\Http\Requests\EditClassLevelRequest;
use ClassLevel\Repositories\ClassLevelRepository;
use Base\Supports\FlashMessage;
use DebugBar;
use ClassLevel\Http\Requests\CreateClassLevelRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Users\Import\UsersImport;
use Users\Repositories\UsersRepository;
use Mail;

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
	public function postCreate(
	    CreateClassLevelRequest $request,
        UsersRepository $usersRepository
    )
	{
		try {
			$input = $request->except('_token');
			$citizenIdentification = $request->get('citizen_identification');

			$checkAvaiable = $usersRepository->scopeQuery(function ($q) use ($citizenIdentification) {
			    return $q->where('citizen_identification', $citizenIdentification);
            })->get();

			if ($checkAvaiable->count() > 0) {
			    return redirect()->back()->withErrors('Mã CMND/CCCD này đã được sử dụng');
            } else {
                $classLevel = $this->repository->create($input);
			    $password = random_string(6);
			    $user = $usersRepository->create([
			        'phone' => $request->get('phone'),
                    'email' => $request->get('email'),
                    'first_name' => $request->get('first_name'),
                    'last_name' => $request->get('last_name'),
                    'password' => $password,
                    'sex' => 'other',
                    'status' => 'active',
                    'classlevel' => $classLevel->id,
                    'is_enterprise' => 1,
                    'hard_role' => 2
                ]);

//			    SendMail::dispatch($user, $password)->delay(Carbon::now()->addMinute(1));
                Mail::to($user)->send(new CreateUserWhenCreateCompany($user, $password));
            }

			return redirect()->back()->with(FlashMessage::returnMessage('create'));
		} catch (\Exception $e) {
			return redirect()->back()->withErrors($e->getMessage());
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

	public function importEmployer(
	    Request $request
    )
    {
        try {
            $classlevel = $request->get('classlevel');

            Excel::import(
                new UsersImport($classlevel),
                $request->file('excel_file')
            );

            return redirect()->back()->with([
                'success' => 'Nhập dữ liệu thành công'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Có lỗi xảy ra khi import dữ liệu');
        }
    }
}