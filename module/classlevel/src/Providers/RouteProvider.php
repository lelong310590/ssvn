<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 2:52 PM
 */

namespace ClassLevel\Providers;

use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider as ServiceProvider;

class RouteProvider extends ServiceProvider
{
	protected $namespace = 'ClassLevel\Http\Controllers';
	
	public function boot()
	{
		parent::boot(); // TODO: Change the autogenerated stub
	}
	
	public function map()
	{
		$this->mapWebRoutes();
		$this->mapApiRoutes();
	}
	
	protected function mapWebRoutes()
	{
		Route::group([
			'middleware' => 'web',
			'namespace' => $this->namespace
		], function($router) {
			require __DIR__.'/../../routes/web.php';
		});
	}
	
	protected function mapApiRoutes()
	{
		Route::group([
			'middleware' => 'api',
			'namespace' => $this->namespace,
			'prefix' => 'api'
		], function($router) {
			require __DIR__.'/../../routes/api.php';
		});
	}
}