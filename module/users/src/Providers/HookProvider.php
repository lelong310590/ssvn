<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/6/2017
 * Time: 10:27 PM
 */

namespace Users\Providers;

use Illuminate\Support\ServiceProvider;
use Users\Hook\UsersHook;

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
		add_action('nqadmin-register-menu', [UsersHook::class, 'handle'], 5);
	}
}