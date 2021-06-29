<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 3:04 PM
 */

namespace Course\Hook;

class CourseHook
{
	public function handle()
	{
		echo view('nqadmin-course::backend.partials.sidebar');
	}
}