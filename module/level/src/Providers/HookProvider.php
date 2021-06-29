<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/6/2018
 * Time: 11:23 PM
 */

namespace Level\Providers;

use Illuminate\Support\ServiceProvider;
use Level\Hook\LevelHook;

class HookProvider extends ServiceProvider
{
	public function boot()
	{
		$this->app->booted(function (){
			$this->booted();
		});
	}
	
	public function register()
	{
	
	}
	
	public function booted()
	{
		add_action('nqadmin-register-course-menu', [LevelHook::class, 'handle'], 15);
	}
}