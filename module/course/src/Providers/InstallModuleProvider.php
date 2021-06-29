<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 3:55 PM
 */

namespace Course\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class InstallModuleProvider extends ServiceProvider
{
	protected $module = 'Course';
	
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
				'name' => 'course_index',
				'display_name' => 'Xem danh sách Khóa đào tạo',
				'description' => 'Xem danh sách Khóa đào tạo'
			],
			[
				'name' => 'course_create',
				'display_name' => 'Thêm Khóa đào tạomới',
				'description' => 'Thêm Khóa đào tạomới'
			],
			[
				'name' => 'course_edit',
				'display_name' => 'Sửa Khóa đào tạo',
				'description' => 'Sửa Khóa đào tạo'
			],
			[
				'name' => 'course_delete',
				'display_name' => 'Xóa Khóa đào tạo',
				'description' => 'Xóa Khóa đào tạo'
			]
		];
		
		if (Schema::hasTable('permissions')) {
			acl_permission($this->module, $permission);
		}
	}
}