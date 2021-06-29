<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 2:59 PM
 */

namespace Course\Providers;

use Course\Hook\CourseHook;
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
	
	public function booted()
	{
		add_action('nqadmin-register-menu', [CourseHook::class, 'handle'], 10);
	}
}