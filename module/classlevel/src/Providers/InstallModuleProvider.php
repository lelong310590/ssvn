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
				'display_name' => 'Xem danh sách Công ty',
				'description' => 'Xem danh sách Công ty'
			],
			[
				'name' => 'classlevel_create',
				'display_name' => 'Thêm Công ty mới',
				'description' => 'Thêm Công ty mới'
			],
			[
				'name' => 'classlevel_edit',
				'display_name' => 'Sửa Công ty',
				'description' => 'Sửa Công ty'
			],
			[
				'name' => 'classlevel_delete',
				'display_name' => 'Xóa Công ty',
				'description' => 'Xóa Công ty'
			]
		];
		
		if (Schema::hasTable('permissions')) {
			acl_permission($this->module, $permission);
		}
	}
}