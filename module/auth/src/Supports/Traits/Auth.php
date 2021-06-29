<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/31/2017
 * Time: 10:29 PM
 */

namespace Auth\Supports\Traits;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;

trait Auth
{
	use AuthenticatesUsers;
	
	protected $maxLoginAttempts = 5;
	
	protected $lockoutTime = 60;
	
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
	 */
	public function login( Request $request )
	{
		$lockedOut = $this->hasTooManyLoginAttempts($request);
		
		if ($lockedOut) {
			$this->fireLockoutEvent($request);
		}
		
		$credentials = $this->credentials($request);
		$credentials['status'] = 'active';
		
		if ($this->guard()->attempt($credentials, $request->has('remember'))) {
			return $this->sendLoginResponse($request);
		}
		
		if (!$lockedOut) {
			$this->incrementLoginAttempts($request);
		}
		
		return $this->sendFailedLoginResponse($request);
	}
	
	protected function sendFailedLoginResponse(Request $request)
	{
		throw ValidationException::withMessages([
			$this->username() => 'Tài khoản hoặc mật khẩu không đúng',
		]);
	}
	
	protected function sendLockoutResponse(Request $request)
	{
		$seconds = $this->limiter()->availableIn(
			$this->throttleKey($request)
		);
		
		throw ValidationException::withMessages([
			$this->username() => 'Không thể đăng nhập trong ' . $seconds,
		])->status(423);
	}
	
	/**
	 * @param \Illuminate\Http\Request $request
	 * @param                          $user
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function authenticated( Request $request, $user )
	{
		return redirect()->to($this->redirectTo);
	}
	
	/**
	 * @return string
	 */
	public function username()
	{
		return 'email';
	}

}