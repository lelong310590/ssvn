<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/26/2017
 * Time: 11:37 AM
 */

namespace Acl\Repositories;

use Acl\Models\Role;
use Prettus\Repository\Eloquent\BaseRepository;

class RoleRepository extends BaseRepository
{
	public function model()
	{
		// TODO: Implement model() method.
		return Role::class;
	}
}