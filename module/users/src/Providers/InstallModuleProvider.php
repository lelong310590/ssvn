<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/26/2017
 * Time: 2:13 PM
 */

namespace Users\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class InstallModuleProvider extends ServiceProvider
{
	protected $module = 'User';
	
	public function boot()
	{
		app()->booted(function () {
			$this->booted();
		});
	}
	
	public function register()
	{
	
	}
	
	public function booted()
	{
		$permission = [
			[
				'name' => 'user_index',
				'display_name' => 'Xem danh sách tài khoản',
				'description' => 'Xem danh sách các tài khoản trong hệ thống'
			],
			[
				'name' => 'user_create',
				'display_name' => 'Thêm tài khoản mới',
				'description' => 'Thêm tài khoản mới'
			],
			[
				'name' => 'user_edit',
				'display_name' => 'Sửa tài khoản',
				'description' => 'Sửa tài khoản'
			],
			[
				'name' => 'user_delete',
				'display_name' => 'Xóa tài khoản',
				'description' => 'Xóa tài khoản'
			],
		];
		
		if (Schema::hasTable('permissions')) {
			acl_permission($this->module, $permission);
		}
		
		$data = [
			[
				'email' => 'admin@anticovid.com',
				'password' => '123456',
				'thumbnail' => 'adminux/img/user-header.png',
				'first_name' => 'Administrator',
				'status' => 'active',
				'sex' => 'male',
			],
		];
		
		if (Schema::hasTable('users')) {
			user_data($data);
			add_user_to_role($data[0]['email']);
		}
		//acl_user_role();
		//acl_role_permission();
	}
}