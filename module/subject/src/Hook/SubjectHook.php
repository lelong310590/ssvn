<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 3:00 PM
 */

namespace Subject\Hook;

class SubjectHook
{
	public function handle()
	{
		echo view('nqadmin-subject::backend.partials.sidebar');
	}
}