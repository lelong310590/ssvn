<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 5/4/2018
 * Time: 10:20 AM
 */

namespace Cart\Providers;

use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider as ServiceProvider;

class RouteProvider extends ServiceProvider
{
	protected $namespace = 'Cart\Http\Controllers';
	
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