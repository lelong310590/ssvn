<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/25/2017
 * Time: 1:59 PM
 */

namespace Acl\Providers;

use Illuminate\Support\ServiceProvider;
use Base\Supports\Helper;

class ModuleProvider extends ServiceProvider
{
	public function boot()
	{
		$this->loadViewsFrom(__DIR__.'/../../resources/views', 'nqadmin-acl');
		$this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
	}
	
	public function register()
	{
		//Load helpers
		Helper::loadModuleHelpers(__DIR__);
		
		$this->mergeConfigFrom(
			__DIR__ . '/../../config/acl.php', 'acl'
		);
		
		$this->app->register(MiddlewareProvider::class);
		$this->app->register(RouteProvider::class);
		$this->app->register(HookProvider::class);
		$this->app->register(InstallModuleProvider::class);
	}
}