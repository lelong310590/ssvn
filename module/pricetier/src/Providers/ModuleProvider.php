<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/9/2018
 * Time: 3:04 PM
 */

namespace PriceTier\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider
{
	public function boot()
	{
		$this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
		$this->loadViewsFrom(__DIR__.'/../../resources/views', 'nqadmin-pricetier');
	}
	
	public function register()
	{
		//$this->app->register(HookProvider::class);
		$this->app->register(RouteProvider::class);
		$this->app->register(InstallModuleProvider::class);
	}
}