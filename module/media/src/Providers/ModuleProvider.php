<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/28/2018
 * Time: 9:28 AM
 */

namespace Media\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider
{
	public function boot()
	{
		$this->loadMigrationsFrom(__DIR__.'./../../database/migrations');
	}
	
	public function register()
	{
		$this->app->register(RouteProvider::class);
	}
}