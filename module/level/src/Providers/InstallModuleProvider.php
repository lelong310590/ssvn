<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/6/2018
 * Time: 11:22 PM
 */

namespace Level\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class InstallModuleProvider extends ServiceProvider
{
	protected $module = 'Level';
	
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
				'name' => 'level_index',
				'display_name' => 'Xem danh sách trình độ',
				'description' => 'Xem danh sách trình độ'
			],
			[
				'name' => 'level_create',
				'display_name' => 'Thêm trình độ mới',
				'description' => 'Thêm trình độ mới'
			],
			[
				'name' => 'level_edit',
				'display_name' => 'Sửa trình độ',
				'description' => 'Sửa trình độ'
			],
			[
				'name' => 'level_delete',
				'display_name' => 'Xóa trình độ',
				'description' => 'Xóa trình độ'
			]
		];
		
		if (Schema::hasTable('permissions')) {
			acl_permission($this->module, $permission);
		}
	}
}