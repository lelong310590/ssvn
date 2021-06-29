<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/6/2017
 * Time: 9:50 PM
 */

namespace Hook\Supports;

abstract class AbstractHookEvent
{
	protected $listeners = [];
	
	public function addListener($hook, $callback, $priority = 20)
	{
		$this->listeners[$hook][$priority] = compact('callback');
	}
	
	public function getListeners()
	{
		foreach ($this->listeners as $key => &$listeners) {
			uksort($listeners, function ($param1, $param2) {
				return strnatcmp($param1, $param2);
			});
		}
		
		return $this->listeners;
	}
	
	protected function getFunction($callback)
	{
		if (is_string($callback)) {
			if (strpos($callback, '@')) {
				$callback = explode('@', $callback);
				return [app('\\' . $callback[0]), $callback[1]];
			} else {
				return $callback;
			}
		} elseif ($callback instanceof \Closure) {
			return $callback;
		} elseif (is_array($callback) && sizeof($callback) > 1) {
			if (is_object($callback[0])) {
				return $callback;
			}
			return [app('\\' . $callback[0]), $callback[1]];
		}
		return null;
	}
	
	abstract function fire($action, array $args);
}