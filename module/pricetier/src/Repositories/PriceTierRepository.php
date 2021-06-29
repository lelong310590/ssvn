<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/9/2018
 * Time: 3:26 PM
 */

namespace PriceTier\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use PriceTier\Models\PriceTier;

class PriceTierRepository extends BaseRepository
{
	public function model()
	{
		return PriceTier::class;
	}
}