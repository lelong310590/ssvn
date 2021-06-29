<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/9/2018
 * Time: 3:08 PM
 */

namespace PriceTier\Providers;

use Illuminate\Support\ServiceProvider;
use PriceTier\Hook\PriceTierHook;

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
		add_action('nqadmin-register-course-menu', [PriceTierHook::class, 'handle'], 20);
	}
}