<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 2:58 PM
 */

namespace Course\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider
{
	public function boot()
	{
		$this->loadViewsFrom(__DIR__. '/../../resources/views', 'nqadmin-course');
		$this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
	}
	
	public function register()
	{
		$this->mergeConfigFrom(__DIR__ . '/../../config/course.php', 'course');
		
		$this->app->register(HookProvider::class);
		$this->app->register(RouteProvider::class);
		$this->app->register(InstallModuleProvider::class);
		$this->app->register(MiddlewareProvider::class);
	}
}