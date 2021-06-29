<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/26/2017
 * Time: 11:30 AM
 */

namespace Acl\Providers;

use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider as ServiceProvider;

class RouteProvider extends ServiceProvider
{
	protected $namespace = 'Acl\Http\Controllers';
	
	public function boot()
	{
		parent::boot();
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