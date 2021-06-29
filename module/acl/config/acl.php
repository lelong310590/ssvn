<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/26/2017
 * Time: 2:52 PM
 */
return [
	
	/*
	|--------------------------------------------------------------------------
	| Entrust Role Model
	|--------------------------------------------------------------------------
	|
	| This is the Role model used by Entrust to create correct relations.  Update
	| the role if it is in a different namespace.
	|
	*/
	'role' => '\Acl\Models\Role',
	
	/*
	|--------------------------------------------------------------------------
	| Entrust Roles Table
	|--------------------------------------------------------------------------
	|
	| This is the roles table used by Entrust to save roles to the database.
	|
	*/
	'roles_table' => 'roles',
	
	/*
	|--------------------------------------------------------------------------
	| Entrust Permission Model
	|--------------------------------------------------------------------------
	|
	| This is the Permission model used by Entrust to create correct relations.
	| Update the permission if it is in a different namespace.
	|
	*/
	'permission' => '\Acl\Models\Permission',
	
	/*
	|--------------------------------------------------------------------------
	| Entrust Permissions Table
	|--------------------------------------------------------------------------
	|
	| This is the permissions table used by Entrust to save permissions to the
	| database.
	|
	*/
	'permissions_table' => 'permissions',
	
	/*
	|--------------------------------------------------------------------------
	| Entrust permission_role Table
	|--------------------------------------------------------------------------
	|
	| This is the permission_role table used by Entrust to save relationship
	| between permissions and roles to the database.
	|
	*/
	'permission_role_table' => 'permission_role',
	
	/*
	|--------------------------------------------------------------------------
	| Entrust role_user Table
	|--------------------------------------------------------------------------
	|
	| This is the role_user table used by Entrust to save assigned roles to the
	| database.
	|
	*/
	'role_user_table' => 'role_user',
	
	/*
	|--------------------------------------------------------------------------
	| User Foreign key on Entrust's role_user Table (Pivot)
	|--------------------------------------------------------------------------
	*/
	'user_foreign_key' => 'user_id',
	
	/*
	|--------------------------------------------------------------------------
	| Role Foreign key on Entrust's role_user Table (Pivot)
	|--------------------------------------------------------------------------
	*/
	'role_foreign_key' => 'role_id',

];