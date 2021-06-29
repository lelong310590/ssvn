<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 3:04 PM
 */

namespace Setting\Hook;

class SettingHook
{
	public function handle()
	{
		echo view('nqadmin-setting::backend.partials.sidebar');
	}
}