<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 1/4/2018
 * Time: 11:00 AM
 */

namespace Acl\Providers;

use Acl\Hook\AclHook;
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
		add_action('nqadmin-register-acl-menu', [AclHook::class, 'handle'], 15);
	}
}