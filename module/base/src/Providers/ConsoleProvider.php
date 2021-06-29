<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 5/6/2018
 * Time: 1:37 AM
 */

namespace Base\Providers;

use Base\Console\Commands\AddPermissionCommand;
use Base\Console\Commands\CreateModuleCommand;
use Illuminate\Support\ServiceProvider;

class ConsoleProvider extends ServiceProvider
{
	public function boot()
	{
	
	}
	
	public function register()
	{
		$this->commands(CreateModuleCommand::class);
        $this->commands(AddPermissionCommand::class);
	}
}