<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/9/2018
 * Time: 3:05 PM
 */

namespace PriceTier\Hook;

class PriceTierHook
{
	public function handle()
	{
		echo view('nqadmin-pricetier::backend.partials.sidebar');
	}
}