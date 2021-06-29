<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/30/2017
 * Time: 11:57 PM
 */

namespace Auth\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Auth\Http\Requests\ValidateSecretRequest;
use Auth\Http\Requests\AuthRequest;
use Barryvdh\Debugbar\Controllers\BaseController;
use Auth\Supports\Traits\Auth;

class AuthController extends BaseController
{
	use Auth;
	
	/**
	 * AuthController constructor.
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => ['getLogout']]);
		
		$this->redirectTo = route('nqadmin::dashboard.index.get');
		$this->redirectPath = route('nqadmin::dashboard.index.get');
		$this->redirectToLoginPage = route('nqadmin::auth.login.get');
	}
	
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function getLogin()
	{
		return view('nqadmin-auth::backend.login');
	}
	
	/**
	 * @param \Auth\Http\Requests\AuthRequest $request
	 *
	 * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
	 */
	public function postLogin(AuthRequest $request)
	{
		return $this->login(request());
	}
	
	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function getLogout()
	{
		$this->guard()->logout();
		
		session()->flush();
		
		session()->regenerate();
		
		return redirect()->to($this->redirectToLoginPage);
	}
	
	/**
	 * Overwrite authenticated method
	 * First logout user and store user to session
	 * Then update secret key
	 *
	 * @param \Illuminate\Http\Request                   $request
	 * @param \Illuminate\Contracts\Auth\Authenticatable $user
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	private function authenticated(Request $request, Authenticatable $user)
	{
		if ($user->google2fa_secret) {
			$this->guard()->logout();

			$request->session()->put('2fa:user:id', $user->id);
			return redirect()->route('nqadmin::2fa.validate.get');
		}
		
		return redirect()->intended($this->redirectTo);
	}
	
	public function getValidateToken()
	{
		if (session('2fa:user:id')) {
			return view('nqadmin-auth::backend.validate');
		}

		return redirect()->to($this->redirectToLoginPage);
	}
	
	public function postValidateToken(ValidateSecretRequest $request)
	{
		//get user id and create cache key
		$userId = $request->session()->pull('2fa:user:id');
		$key    = $userId . ':' . $request->totp;
		
		//use cache to store token to blacklist
		Cache::add($key, true, 4);
		
		//login and redirect user
		$this->guard()->loginUsingId($userId);
		
		return redirect()->intended($this->redirectTo);
	}
}