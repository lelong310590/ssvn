<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/30/2017
 * Time: 11:08 PM
 */

namespace Auth\Providers;

use Auth\Http\Middleware\Authenticated;
use Auth\Http\Middleware\CheckIsAdmin;
use Illuminate\Support\ServiceProvider;

class MiddlewareProvider extends ServiceProvider
{
	public function boot()
	{
	
	}
	
	public function register()
	{
		$this->app['router']->aliasMiddleware('nqadmin', Authenticated::class);
		$this->app['router']->pushMiddlewareToGroup('web', Authenticated::class);
        $this->app['router']->aliasMiddleware('verfiry-admin', CheckIsAdmin::class);
        $this->app['router']->pushMiddlewareToGroup('verfiry-admin', CheckIsAdmin::class);
    }
}