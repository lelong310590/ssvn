<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 2:55 PM
 */

namespace ClassLevel\Hook;

class ClassLevelHook
{
	public function handle()
	{
		echo view('nqadmin-classlevel::backend.partials.sidebar');
	}
}