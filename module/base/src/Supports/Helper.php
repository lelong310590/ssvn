<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/1/2017
 * Time: 8:57 AM
 */

namespace Base\Supports;

class Helper
{
	public static function loadModuleHelpers($dir)
	{
		$helpers = \File::glob($dir . '/../../helpers/*.php');
		foreach ($helpers as $helper) {
			require_once $helper;
		}
	}
}