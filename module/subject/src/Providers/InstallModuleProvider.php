<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/6/2018
 * Time: 10:27 AM
 */

namespace Subject\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class InstallModuleProvider extends ServiceProvider
{
	protected $module = 'Subject';
	
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
				'name' => 'subject_index',
				'display_name' => 'Xem danh sách Chứng chỉ',
				'description' => 'Xem danh sách Chứng chỉ'
			],
			[
				'name' => 'subject_create',
				'display_name' => 'Thêm Chứng chỉ mới',
				'description' => 'Thêm Chứng chỉ mới'
			],
			[
				'name' => 'subject_edit',
				'display_name' => 'Sửa Chứng chỉ',
				'description' => 'Sửa Chứng chỉ'
			],
			[
				'name' => 'subject_delete',
				'display_name' => 'Xóa Chứng chỉ',
				'description' => 'Xóa Chứng chỉ'
			]
		];
		
		if (Schema::hasTable('permissions')) {
			acl_permission($this->module, $permission);
		}
	}
}