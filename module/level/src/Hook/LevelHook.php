<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/6/2018
 * Time: 11:18 PM
 */

namespace Level\Hook;


class LevelHook
{
	public function handle()
	{
		echo view('nqadmin-level::backend.partials.sidebar');
	}
}