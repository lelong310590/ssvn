<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/6/2017
 * Time: 10:47 PM
 */

namespace Users\Hook;

class UsersHook
{
	public function handle()
	{
		echo view('nqadmin-users::backend.partials.sidebar');
	}
}