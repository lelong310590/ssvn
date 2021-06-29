<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 2:59 PM
 */

namespace Setting\Providers;

use Setting\Hook\SettingHook;
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
		add_action('nqadmin-register-menu', [SettingHook::class, 'handle'], 100);
	}
}