<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/31/2017
 * Time: 10:39 PM
 */

namespace Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Authenticated
{
	const LOGIN_ROUTE_NAME_GET = 'nqadmin::auth.login.get';
	
	const LOGIN_ROUTE_NAME_POST = 'nqadmin::auth.login.post';
	
	const DASHBOARD_ROUTE_NAME_GET = 'nqadmin::dashboard.index.get';
	
	const VALIDATE_ROUTE_NAME_GET = 'nqadmin::2fa.validate.get';
	
	const VALIDATE_ROUTE_NAME_POST = 'nqadmin::2fa.validate.post';
	
	/**
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure                 $next
	 *
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|mixed|\Symfony\Component\HttpFoundation\Response
	 */
	public function handle(Request $request, Closure $next, $guard = null)
	{
		$currentRouteName = $request->route()->getName();
		if ($currentRouteName == $this::LOGIN_ROUTE_NAME_GET || $currentRouteName == $this::LOGIN_ROUTE_NAME_POST
			|| $currentRouteName == $this::VALIDATE_ROUTE_NAME_GET || $currentRouteName == $this::VALIDATE_ROUTE_NAME_POST
		) {
			return $next($request);
		}
		
		if (is_in_dashboard()) {
			if (auth('nqadmin')->guest()) {
				if ($request->ajax() || $request->wantsJson()) {
					return response('Unauthorized.', \Constants::UNAUTHORIZED_CODE);
				}
				return redirect()->guest(route($this::LOGIN_ROUTE_NAME_GET));
			}
		} else {

		}
		
//		if (auth('nqadmin')->check()) {
//			$checkPerms = auth()->user()->can('access_dashboard');
//			return redirect()->guest(route('nqadmin::dashboard.index.get'));
//		}
		
		
		return $next($request);
	}
}