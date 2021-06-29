<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 2:53 PM
 */

namespace ClassLevel\Providers;

use ClassLevel\Hook\ClassLevelHook;
use Illuminate\Support\ServiceProvider;

class HookProvider extends ServiceProvider
{
	public function boot()
	{
		$this->app->booted(function () {
			$this->booted();
		});
	}
	
	public function register()
	{
	
	}
	
	private function booted()
	{
		add_action('nqadmin-register-course-menu', [ClassLevelHook::class, 'handle'], 5);
	}
}