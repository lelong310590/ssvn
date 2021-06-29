<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/6/2018
 * Time: 10:51 PM
 */

namespace Level\Providers;

use Base\Supports\Helper;
use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider
{
	public function boot()
	{
		$this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
		$this->loadViewsFrom(__DIR__.'/../../resources/views', 'nqadmin-level');
	}
	
	public function register()
	{
		Helper::loadModuleHelpers(__DIR__);
		$this->app->register(InstallModuleProvider::class);
		//$this->app->register(HookProvider::class);
		$this->app->register(RouteProvider::class);
	}
}