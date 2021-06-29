<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 5/6/2018
 * Time: 1:31 AM
 */

namespace Base\Console\Commands;

use Illuminate\Console\Command;
use File;

class CreateModuleCommand extends Command
{
	protected $signature = 'create-module {name}';
	
	protected $description = 'Create new module';
	
	protected $root = 'module/';
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function handle()
	{
		$moduleName = $this->argument('name');
		$moduleName = str_slug($moduleName, '');
		$this->createFolderStructure($moduleName);
	}
	
	public function createFolderStructure($name)
	{
		$mainFolder = $this->root.$name;
		
		if (!File::exists($mainFolder)) {
			File::makeDirectory($mainFolder, 0775, true, true);
		} else {
			$this->error('This module is exits!');
		}
		
		$folderStructure = [
			$mainFolder.'/config',
			$mainFolder.'/database/migrations',
			$mainFolder.'/helpers',
			$mainFolder.'/resources/views',
			$mainFolder.'/resources/views/backend',
			$mainFolder.'/resources/views/frontend',
			$mainFolder.'/routes',
			$mainFolder.'/src',
			$mainFolder.'/src/Http',
			$mainFolder.'/src/Http/Controllers',
			$mainFolder.'/src/Http/Requests',
			$mainFolder.'/src/Models',
			$mainFolder.'/src/Providers',
			$mainFolder.'/src/Repositories',
		];
		
		$bar = $this->output->createProgressBar(count($folderStructure));
		
		foreach ($folderStructure as $f) {
			File::makeDirectory($f, 0775, true, true);
			$bar->advance();
		}
		
		$bar->finish();
		
		File::put($folderStructure[6].'/web.php', '');
		File::put($folderStructure[6].'/api.php', '');
		File::put($folderStructure[12].'/ModuleProvider.php', '');
		
		$this->info('Module is created');
	}
}