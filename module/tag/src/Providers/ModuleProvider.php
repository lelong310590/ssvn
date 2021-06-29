<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/10/2018
 * Time: 2:45 PM
 */

namespace Tag\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleProvider extends ServiceProvider
{
	public function boot()
	{
		$this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
	}
	
	public function register()
	{
	
	}
}