<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 2:48 PM
 */

namespace ClassLevel\Providers;

use Base\Supports\Helper;
use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider
{
	public function boot()
	{
		$this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
		$this->loadViewsFrom(__DIR__.'/../../resources/views', 'nqadmin-classlevel');
	}
	
	public function register()
	{
		Helper::loadModuleHelpers(__DIR__);
		$this->app->register(RouteProvider::class);
		$this->app->register(InstallModuleProvider::class);
		//$this->app->register(HookProvider::class);
	}
}