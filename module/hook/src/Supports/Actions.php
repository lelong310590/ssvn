<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/6/2017
 * Time: 9:56 PM
 */

namespace Hook\Supports;

class Actions extends AbstractHookEvent
{
	public function fire($action, array $args)
	{
		if ($this->getListeners()) {
			foreach ($this->getListeners() as $hook => $listeners) {
				foreach ($listeners as $arguments) {
					if ($hook === $action) {
						call_user_func_array($this->getFunction($arguments['callback']), $args);
					}
				}
			}
		}
	}
}