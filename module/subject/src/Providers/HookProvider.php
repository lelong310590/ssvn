<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 2:59 PM
 */

namespace Subject\Providers;

use Illuminate\Support\ServiceProvider;
use Subject\Hook\SubjectHook;

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
		add_action('nqadmin-register-course-menu', [SubjectHook::class, 'handle'], 10);
	}
}