<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/26/2017
 * Time: 11:55 AM
 */

namespace Acl\Providers;

use Acl\Models\Permission;
use Acl\Models\Role;
use ClassLevel\Models\ClassLevel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Level\Models\Level;
use Subject\Models\Subject;
use Users\Models\Users;

class InstallModuleProvider extends ServiceProvider
{
	protected $module = 'Acl';
	
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
				'name' => 'access_dashboard',
				'display_name' => 'Truy cập quản trị',
				'description' => 'Truy cập quản trị'
			],
			[
				'name' => 'role_index',
				'display_name' => 'Xem danh sách vai trò',
				'description' => 'Xem danh sách các vai trò trong hệ thống'
			],
			[
				'name' => 'role_create',
				'display_name' => 'Thêm vai trò mới',
				'description' => 'Thêm vai trò mới'
			],
			[
				'name' => 'role_edit',
				'display_name' => 'Sửa vai trò',
				'description' => 'Sửa vai trò'
			],
			[
				'name' => 'role_delete',
				'display_name' => 'Xóa vai trò',
				'description' => 'Xóa vai trò'
			],
			[
				'name' => 'permission_index',
				'display_name' => 'Xem danh sách quyền',
				'description' => 'Xem danh sách các quyền trong hệ thống'
			]
		];
		
		if (Schema::hasTable('permissions')) {
			acl_permission($this->module, $permission);
		}
		
		$data = [
			[
				'name' => 'administrator',
				'display_name' => 'Administrator',
				'description' => 'Tài khoản quản trị cao cấp'
			],
			[
				'name' => 'moderator',
				'display_name' => 'Moderator',
				'description' => 'Tài khoản thành viên cao cấp'
			],
		];
		
		if (Schema::hasTable('roles')) {
			acl_data($data);
		}
		
//		$roleModel = new Role;
//		$rolePerms = new Permission;
//		$allPerms = $rolePerms->select('id')->get();
//		$roleAdmin = $roleModel->where('name', 'administrator')->first();
//		$roleAdmin->perms()->sync($allPerms);
		
		//$user = Users::find(1);//		for($i = 3; $i <= 12; $i ++) {
//			$classModel = new ClassLevel;
//			$classModel->name = 'Lớp '.$i;
//			$classModel->slug = 'lop-'.$i;
//			$classModel->seo_title = 'Lớp '.$i;
//			$classModel->author = $user->id;
//			$classModel->status = 'active';
//			$classModel->save();
//		}
//
//		$subject = ['Toán học', 'Văn học', 'Tiếng Anh', 'Hóa học', 'Vậy lý', 'Sinh học', 'Địa lý'];
//		foreach ($subject as $s) {
//			$model = new Subject;
//			$model->name = $s;
//			$model->slug = str_slug($s);
//			$model->author = $user->id;
//			$model->seo_title = $s;
//			$model->icon = '';
//			$model->save();
//		}
//
//		$classModel = new ClassLevel;
//		$model = new Subject;
//		$allClass = $classModel->orderBy('id', 'asc')->get();
//		$allSubject = $model->orderBy('id', 'asc')->get();
//
//		foreach ($allSubject as $subj) {
//			$subj->classLevel()->sync($allClass);
//		}
//
//		$level = ['Cho học sinh mất gốc', 'Cho học sinh giỏi', 'Khóa đào tạocao', 'Ôn học sinh cấp 3', 'Ôn thi đại học'];
//		$user = Users::find(1);
//		foreach ($level as $lvl) {
//			$model = new Level();
//			$model->name = $lvl;
//			$model->slug = str_slug($lvl);
//			$model->author = $user->id;
//			$model->status = 'active';
//			$model->featured = 'active';
//			$model->save();
//		}
	
	}
}