<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/26/2017
 * Time: 11:21 AM
 */

namespace Acl\Models;

use Zizaco\Entrust\EntrustPermission;
use Illuminate\Support\Facades\Config;

class Permission extends EntrustPermission
{
	protected $table;
	
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->table = Config::get('acl.permissions_table');
	}
	
	public function roles()
	{
		return $this->belongsToMany(Config::get('acl.role'), Config::get('acl.permission_role_table'));
	}
	
	/**
	 * Boot the permission model
	 * Attach event listener to remove the many-to-many records when trying to delete
	 * Will NOT delete any records if the permission model uses soft deletes.
	 *
	 * @return void|bool
	 */
	public static function boot()
	{
		parent::boot();
		
		static::deleting(function($permission) {
			if (!method_exists(Config::get('acl.permission'), 'bootSoftDeletes')) {
				$permission->roles()->sync([]);
			}
			
			return true;
		});
	}
}