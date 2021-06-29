<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/26/2017
 * Time: 11:02 AM
 */

namespace Acl\Providers;

use Illuminate\Support\ServiceProvider;
use Zizaco\Entrust\Middleware\EntrustRole;
use Zizaco\Entrust\Middleware\EntrustPermission;
use Zizaco\Entrust\Middleware\EntrustAbility;

class MiddlewareProvider extends ServiceProvider
{
	public function boot()
	{
	
	}
	
	public function register()
	{
		$router = $this->app['router'];
		$router->aliasMiddleware('role', EntrustRole::class);
		$router->aliasMiddleware('permission', EntrustPermission::class);
		$router->aliasMiddleware('ability', EntrustAbility::class);
	}
}