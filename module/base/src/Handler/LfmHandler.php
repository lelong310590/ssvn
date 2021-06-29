<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/27/2017
 * Time: 2:38 PM
 */

namespace Base\Handler;

use Unisharp\Laravelfilemanager\Handlers\ConfigHandler;

class LfmHandler extends ConfigHandler
{
	public function userField()
	{
		return auth()->user()->email;
	}
}