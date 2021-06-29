<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/26/2017
 * Time: 11:38 AM
 */

namespace Acl\Repositories;

use Acl\Models\Permission;
use Prettus\Repository\Eloquent\BaseRepository;

class PermissionRepository extends BaseRepository
{
	public function model()
	{
		// TODO: Implement model() method.
		return Permission::class;
	}
}