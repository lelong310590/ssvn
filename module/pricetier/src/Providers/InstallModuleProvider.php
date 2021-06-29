<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/9/2018
 * Time: 3:19 PM
 */

namespace PriceTier\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class InstallModuleProvider extends ServiceProvider
{
	protected $module = 'PriceTier';
	
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
				'name' => 'pricetier_index',
				'display_name' => 'Xem danh sách giá',
				'description' => 'Xem danh sách giá'
			],
			[
				'name' => 'pricetier_create',
				'display_name' => 'Thêm giá mới',
				'description' => 'Thêm giá mới'
			],
			[
				'name' => 'pricetier_edit',
				'display_name' => 'Sửa giá',
				'description' => 'Sửa giá'
			],
			[
				'name' => 'pricetier_delete',
				'display_name' => 'Xóa giá',
				'description' => 'Xóa giá'
			]
		];
		
		if (Schema::hasTable('permissions')) {
			acl_permission($this->module, $permission);
		}
	}
	
}