<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/26/2017
 * Time: 11:35 AM
 */

namespace Acl\Http\Controllers;

use Acl\Repositories\PermissionRepository;
use Barryvdh\Debugbar\Controllers\BaseController;

class PermissionController extends BaseController
{
	private $perm;
	
	function __construct(PermissionRepository $permissionRepository)
	{
		$this->perm = $permissionRepository;
	}
	
	public function getIndex()
	{
		$perms = $this->perm->orderBy('module', 'asc')->all();
		return view('nqadmin-acl::backend.components.permission.index', [
			'data' => $perms
		]);
	}
}