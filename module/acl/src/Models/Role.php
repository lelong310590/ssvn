<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/26/2017
 * Time: 11:22 AM
 */

namespace Acl\Models;

use Zizaco\Entrust\EntrustRole;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;

class Role extends EntrustRole
{
	protected $guarded = [];
	
	public function setNameAttribute($value)
	{
		$this->attributes['name'] = str_slug($value, '-');
	}
	
	/**
	 * Creates a new instance of the model.
	 *
	 * @param array $attributes
	 */
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->table = Config::get('acl.roles_table');
	}
	
	//Big block of caching functionality.
	public function cachedPermissions()
	{
		$rolePrimaryKey = $this->primaryKey;
		$cacheKey = 'entrust_permissions_for_role_'.$this->$rolePrimaryKey;
		return Cache::tags(Config::get('acl.permission_role_table'))->remember($cacheKey, Config::get('cache.ttl'), function () {
			return $this->perms()->get();
		});
	}
	public function save(array $options = [])
	{   //both inserts and updates
		$result = parent::save($options);
		Cache::tags(Config::get('acl.permission_role_table'))->flush();
		return $result;
	}
	public function delete(array $options = [])
	{   //soft or hard
		$result = parent::delete($options);
		Cache::tags(Config::get('acl.permission_role_table'))->flush();
		return $result;
	}
	public function restore()
	{   //soft delete undo's
		$result = parent::restore();
		Cache::tags(Config::get('acl.permission_role_table'))->flush();
		return $result;
	}
	
	/**
	 * Many-to-Many relations with the user model.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users()
	{
		return $this->belongsToMany(
			Config::get('auth.providers.users.model'),
			Config::get('acl.role_user_table'),
			Config::get('acl.role_foreign_key'),
			Config::get('acl.user_foreign_key'));
		// return $this->belongsToMany(Config::get('auth.model'), Config::get('acl.role_user_table'));
	}
	
	/**
	 * Many-to-Many relations with the permission model.
	 * Named "perms" for backwards compatibility. Also because "perms" is short and sweet.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function perms()
	{
		return $this->belongsToMany(Config::get('acl.permission'), Config::get('acl.permission_role_table'));
	}
	
	/**
	 * Boot the role model
	 * Attach event listener to remove the many-to-many records when trying to delete
	 * Will NOT delete any records if the role model uses soft deletes.
	 *
	 * @return void|bool
	 */
	public static function boot()
	{
		parent::boot();
		
		static::deleting(function($role) {
			if (!method_exists(Config::get('acl.role'), 'bootSoftDeletes')) {
				$role->users()->sync([]);
				$role->perms()->sync([]);
			}
			
			return true;
		});
	}
}