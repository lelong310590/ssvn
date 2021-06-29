<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 5/6/2018
 * Time: 11:21 PM
 */

namespace MultipleChoices\Providers;

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