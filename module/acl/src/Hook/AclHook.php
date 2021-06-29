<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 1/4/2018
 * Time: 10:59 AM
 */

namespace Acl\Hook;

class AclHook
{
	public function handle()
	{
		echo view('nqadmin-acl::backend.partials.sidebar');
	}
}