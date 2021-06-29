<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 3:43 PM
 */

namespace ClassLevel\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class InstallModuleProvider extends ServiceProvider
{
	protected $module = 'ClassLevel';
	
	public function boot()
	{
		app()->booted(function () {
			$this->booted();
		});
	}
	
	public function register()
	{
	
	}
	
	private function booted()
	{
		$permission = [
			[
				'name' => 'classlevel_index',
				'display_name' => 'Xem danh sách lớp',
				'description' => 'Xem danh sách lớp'
			],
			[
				'name' => 'classlevel_create',
				'display_name' => 'Thêm lớp mới',
				'description' => 'Thêm lớp mới'
			],
			[
				'name' => 'classlevel_edit',
				'display_name' => 'Sửa lớp',
				'description' => 'Sửa lớp'
			],
			[
				'name' => 'classlevel_delete',
				'display_name' => 'Xóa lớp',
				'description' => 'Xóa lớp'
			]
		];
		
		if (Schema::hasTable('permissions')) {
			acl_permission($this->module, $permission);
		}
	}
}