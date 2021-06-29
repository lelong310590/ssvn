<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/6/2017
 * Time: 9:58 PM
 */

namespace Hook\Facades;

use Illuminate\Support\Facades\Facade;
use Hook\Supports\Actions;

class ActionsFacade extends Facade
{
	protected static function getFacadeAccessor()
	{
		return Actions::class;
	}
}