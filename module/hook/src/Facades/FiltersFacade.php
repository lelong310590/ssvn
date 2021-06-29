<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/6/2017
 * Time: 9:59 PM
 */

namespace Hook\Facades;

use Illuminate\Support\Facades\Facade;
use Hook\Supports\Filters;

class FiltersFacade extends Facade
{
	protected static function getFacadeAccessor()
	{
		return Filters::class;
	}
}