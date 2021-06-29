<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/6/2018
 * Time: 11:18 PM
 */

namespace Level\Repositories;

use Level\Models\Level;
use Prettus\Repository\Eloquent\BaseRepository;

class LevelRepository extends BaseRepository
{
	public function model()
	{
		return Level::class;
	}
}