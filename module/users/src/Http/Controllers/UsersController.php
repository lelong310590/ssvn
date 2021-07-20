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
use Course\Models\Certificate;
use Course\Repositories\CertificateRepository;
use Course\Repositories\CurriculumProgressRepository;
use Course\Repositories\TestResultRepository;
use Users\Events\ChangeUserCompanyEvent;
use Users\Http\Requests\ManagerRequest;
use Users\Http\Requests\TransferRequest;
use Users\Http\Requests\UserCreateRequest;
use Users\Http\Requests\UserEditRequest;
use Illuminate\Http\Request;
use Users\Models\Users;
use Users\Repositories\UsersMetaRepository;
use Users\Repositories\UsersRepository;

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
	public function getIndex(
	    Request $request,
        ClassLevelRepository $classLevelRepository
    )
	{
	    $classlevel = $classLevelRepository->findWhere(['status' => 'active']);
        if($request->get('keyword') || $request->get('company')){
            $keyword = $request->get('keyword');
            $company = $request->get('company');
            $users = $this->users->with('getClassLevel')->scopeQuery(function($e) use($keyword, $company){
                if ($keyword && $company) {
                    $query = $e->where('phone', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('first_name', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('last_name', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('citizen_identification', 'LIKE', '%'.$keyword.'%')
                        ->where('classlevel', $company);
                } elseif ($keyword) {
                    $query = $e->where('phone', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('first_name', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('citizen_identification', 'LIKE', '%'.$keyword.'%');
                } else {
                    $query = $e->where('classlevel', $company);
                }
                return $query;
            })->orderBy('created_at', 'desc')->paginate(25);
        }else {
            $users = $this->users
                ->with('roles')
                ->with('getClassLevel')
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        }

		return view('nqadmin-users::backend.components.index', [
			'data' => $users,
            'classlevel' => $classlevel
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
//			$user->roles()->sync($data['role']);

			if ($request->has('continue_edit')) {
				return redirect()->route('nqadmin::users.edit.get', [
					'id' => $user->id
				])->with(FlashMessage::returnMessage('create'));
			}
			
			return redirect()->route('nqadmin::users.index.get')->with(FlashMessage::returnMessage('create'));
			
		} catch (\Exception $e) {
			return redirect()->back()->withErrors($e->getMessage());
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
	public function postEdit(
	    $id,
        UserEditRequest $request
    )
	{
		try {
			if ($request->get('password') == null) {
				$data = $request->except(['_token', 'email', 'password', 're_password']);
			} else {
				$data = $request->except(['_token', 'email']);
			}

			$this->users->update($data, $id);

            event(new ChangeUserCompanyEvent($id, 'personal', $request->get('classlevel')));
//			$user->roles()->sync($data['role']);

			return redirect()->back()->with(FlashMessage::returnMessage('edit'));
		} catch (\Exception $e) {
			return redirect()->back()->withErrors($e->getMessage());
		}
	}
	
	/**
	 * @param $id
	 *
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function getDelete(
	    $id,
        OrderDetailsRepository $orderDetailsRepository,
        OrdersRepository $ordersRepository,
        CurriculumProgressRepository $curriculumProgressRepository,
        TestResultRepository $testResultRepository
    )
	{
        $orderDetailsRepository->deleteWhere(['customer' => $id]);
        $ordersRepository->deleteWhere(['customer' => $id]);
        $curriculumProgressRepository->deleteWhere(['student' => $id]);
        $testResultRepository->deleteWhere(['owner' => $id]);

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

    /**
     * @param Request $request
     * @param UsersMetaRepository $usersMetaRepository
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function getEmployer(
        Request $request,
        ClassLevelRepository $classLevelRepository
    )
    {
        if($request->get('keyword')){
            $keyword = $request->get('keyword');
            $company = $classLevelRepository->scopeQuery(function($e) use($keyword){
                return $e->where('name', 'LIKE', '%'.$keyword.'%')
                    ->orWhere('mst', 'LIKE', '%'.$keyword.'%');
            })->orderBy('created_at', 'desc')->paginate(30);
        }else {
            $company = $classLevelRepository
                ->orderBy('created_at', 'desc')
                ->paginate(25);

        }
        return view('nqadmin-users::backend.components.employer', compact('company'));
    }

    /**
     * @param $id
     * @param RoleRepository $roleRepository
     * @param ClassLevelRepository $classLevelRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function getTransfer(
        $id,
        Request $request,
        ClassLevelRepository $classLevelRepository,
        UsersRepository $usersRepository
    )
    {
        $company =  $classLevelRepository->find($id);
        if ($request->get('keyword') != null) {
            $keyword = $request->get('keyword');
            $employer = $usersRepository->getModel()
                ->with('getManager')
                ->where([
                    ['status', '=', 'active'],
                    ['classlevel', '=' , $id],
                    ['hard_role', '=' ,1]
                ])
                ->where(function($query) use ($keyword) {
                    $query->where('phone', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('first_name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('citizen_identification', 'LIKE', '%' . $keyword . '%');
                })
                ->paginate(30);
        } else {
            $employer = $usersRepository->getModel()
                ->with('getManager')
                ->where('status', 'active')
                ->where('hard_role', 1)
                ->where('classlevel', $id)
                ->paginate(30);
        }

        $manager = $usersRepository->getModel()
            ->where('status', 'active')
            ->whereIn('hard_role', [2, 3])
            ->where('classlevel', $id)
            ->get();

        return view('nqadmin-users::backend.components.transfer', compact(
            'company', 'employer', 'manager'
        ));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function postTransfer(
        TransferRequest $request
    )
    {
        $action = $request->get('action');
        $employer = $request->get('employers');
        switch ($action) {
            case 'transfer':
                $manager = $request->get('manager');
                Users::whereIn('id', $employer)
                        ->update([
                            'manager' => $manager
                        ]);
                break;
            case 'fire':
                Users::whereIn('id', $employer)
                    ->update([
                        'classlevel' => null,
                        'hard_role' => 1
                    ]);

                //Change certificate status
                event(new ChangeUserCompanyEvent($employer, 'personal', null));

                break;
            case 'up':
                Users::whereIn('id', $employer)
                    ->update([
                        'hard_role' => 2
                    ]);
                break;
            default:

        }

        return redirect()->back()->with(FlashMessage::returnMessage('edit'));
    }

    /**
     * @param $id
     * @param Request $request
     * @param ClassLevelRepository $classLevelRepository
     * @param UsersRepository $usersRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function getManager(
        $id,
        Request $request,
        ClassLevelRepository $classLevelRepository,
        UsersRepository $usersRepository
    )
    {
        $company =  $classLevelRepository->find($id);
        if ($request->get('keyword') != null) {
            $keyword = $request->get('keyword');
            $manager = $usersRepository->getModel()
                ->withCount('getEmployer')
                ->where([
                    ['status', '=', 'active'],
                    ['classlevel', '=' , $id],
                ])
                ->whereIn('hard_role', [2, 3])
                ->where(function($query) use ($keyword) {
                    $query->where('phone', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('first_name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('citizen_identification', 'LIKE', '%' . $keyword . '%');
                })
                ->paginate(30);
        } else {
            $manager = $usersRepository->getModel()
                ->withCount('getEmployer')
                ->where('status', 'active')
                ->where('classlevel', $id)
                ->whereIn('hard_role', [2, 3])
                ->paginate(30);
        }

        return view('nqadmin-users::backend.components.manager', compact(
            'company', 'manager'
        ));
    }

    public function postManager(
        $id,
        ManagerRequest $request
    )
    {
        $action = $request->get('action');
        $manager = $request->get('manager');
        $changeManager = $request->get('change_manager');
        switch ($action) {
            case 'getall':
                Users::where('classlevel', $id)
                    ->where('hard_role', 1)
                    ->where('manager', null)
                    ->update([
                        'manager' => $manager
                    ]);
                break;
            case 'fire':
                Users::where('id', $manager)
                    ->update([
                        'hard_role' => 1,
                        'classlevel' => null
                    ]);

                //Change certificate status
                event(new ChangeUserCompanyEvent($manager, 'personal', null));

                //Change manager
                Users::where('manager', $manager)
                    ->update([
                        'manager' => $changeManager
                    ]);

                break;
            case 'down':
                Users::where('id', $manager)
                    ->update([
                        'hard_role' => 1,
                    ]);

                //Change manager
                Users::where('manager', $manager)
                    ->update([
                        'manager' => $changeManager
                    ]);
                
                break;
            default:
        }

        return redirect()->back()->with(FlashMessage::returnMessage('edit'));
    }
}