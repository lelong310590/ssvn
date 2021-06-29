<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/6/2017
 * Time: 9:57 PM
 */

namespace Hook\Supports;


class Filters extends AbstractHookEvent
{
	public function fire($action, array $args)
	{
		$value = isset($args[0]) ? $args[0] : '';
		if ($this->getListeners()) {
			foreach ($this->getListeners() as $hook => $listeners) {
				foreach ($listeners as $arguments) {
					if ($hook === $action) {
						$value = call_user_func_array($this->getFunction($arguments['callback']), $args);
					}
				}
			}
		}
		return $value;
	}
}