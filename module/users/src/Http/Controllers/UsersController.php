<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/6/2017
 * Time: 11:23 PM
 */
namespace Users\Http\Controllers;

use Acl\Repositories\RoleRepository;
use Barryvdh\Debugbar\Controllers\BaseController;
use Base\Supports\FlashMessage;
use Cart\Repositories\OrderDetailsRepository;
use Cart\Repositories\OrdersRepository;
use ClassLevel\Repositories\ClassLevelRepository;
use Course\Repositories\CurriculumProgressRepository;
use MultipleChoices\Repositories\QuestionRepository;
use Users\Http\Requests\UserCreateRequest;
use Users\Http\Requests\UserEditRequest;
use Illuminate\Http\Request;
use Users\Repositories\UsersMetaRepository;
use Users\Repositories\UsersRepository;
use Debugbar;

class UsersController extends BaseController
{
	protected $users;
	
	public function __construct(UsersRepository $repository)
	{
		$this->users = $repository;
	}
	
	public function getSetting()
	{
		return view('nqadmin-users::backend.components.setting');
	}
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getIndex(Request $request)
	{
        if($request->get('email')){
            $email = $request->get('email');
            $users = $this->users->with('getClassLevel')->scopeQuery(function($e) use($email){
                return $e->where(['email'=>$email]);
            })->orderBy('created_at', 'desc')->paginate(25);
        }else {
            $users = $this->users
                ->with('roles')
                ->with('getClassLevel')
                ->orderBy('created_at', 'desc')
                ->paginate(25);

        }

		return view('nqadmin-users::backend.components.index', [
			'data' => $users
		]);
	}
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getCreate(RoleRepository $roleRepository, ClassLevelRepository $classLevelRepository)
	{
        $classLevel = $classLevelRepository->findWhere([
            'status' => 'active'
        ]);
		$role = $roleRepository->all();
		return view('nqadmin-users::backend.components.create', [
			'role' => $role,
            'classLevel' => $classLevel
		]);
	}
	
	/**
	 * @param \Users\Http\Requests\UserCreateRequest $request
	 *
	 * @return bool|\Illuminate\Http\RedirectResponse
	 */
	public function postCreate(
	    UserCreateRequest $request,
        UsersMetaRepository $usersMetaRepository
    )
	{
		try {
			$data = $request->except(['_token', 'continue_edit']);
			$user = $this->users->create($data);
			$user->roles()->sync($data['role']);
            $usersMetaRepository->create([
                'users_id' => $user->id,
                'meta_key' => 'autoplay',
                'meta_value' => true
            ]);
			if ($request->has('continue_edit')) {
				return redirect()->route('nqadmin::users.edit.get', [
					'id' => $user->id
				])->with(FlashMessage::returnMessage('create'));
			}
			
			return redirect()->route('nqadmin::users.index.get')->with(FlashMessage::returnMessage('create'));
			
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
	public function getEdit(
	    $id,
        RoleRepository $roleRepository,
        ClassLevelRepository $classLevelRepository
    )
	{
		$classLevel = $classLevelRepository->findWhere([
		    'status' => 'active'
        ]);
		$user = $this->users->find($id);
		$roles = $roleRepository->all();
		return view('nqadmin-users::backend.components.edit', [
			'data' => $user,
			'role' => $roles,
            'classLevel' => $classLevel
		]);
	}
	
	/**
	 * @param \Users\Http\Requests\UserEditRequest $request
	 */
	public function postEdit($id, UserEditRequest $request)
	{
		try {
			if ($request->get('password') == null) {
				$data = $request->except(['_token', 'email', 'password', 're_password']);
			} else {
				$data = $request->except(['_token', 'email']);
			}

			$user = $this->users->update($data, $id);
			$user->roles()->sync($data['role']);

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
	public function getDelete($id, OrderDetailsRepository $orderDetailsRepository,
                              OrdersRepository $ordersRepository,
                              CurriculumProgressRepository $curriculumProgressRepository
    )
	{
        $orderDetailsRepository->deleteWhere(['customer' => $id]);
        $ordersRepository->deleteWhere(['customer' => $id]);
        $curriculumProgressRepository->deleteWhere(['student' => $id]);
		return getDelete($id, $this->users);
	}

    /**
     * @param Request $request
     * @param UsersMetaRepository $usersMetaRepository
     * @return mixed
     */
	public function getAutoplay(Request $request, UsersMetaRepository $usersMetaRepository)
    {
        $id = $request->get('id');
        $autoplay = $usersMetaRepository->findWhere([
            'users_id' => $id,
            'meta_key' => 'autoplay'
        ])->first();
        return $autoplay;
    }

    public function setAutoplay(Request $request, UsersMetaRepository $usersMetaRepository)
    {
        $data = $request->all();
        $autoPlay = ($data['autoplay'] == true) ? 'true' : 'false';
        $metaUser = $usersMetaRepository->findWhere([
            'users_id' => $data['userid'],
            'meta_key' => 'autoplay'
        ])->first();

        $usersMetaRepository->update([
            'meta_value' => $autoPlay
        ], $metaUser->id);
    }
}