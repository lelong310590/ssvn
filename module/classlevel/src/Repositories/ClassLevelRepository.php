<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 10:36 AM
 */

namespace ClassLevel\Repositories;

use ClassLevel\Models\ClassLevel;
use Prettus\Repository\Eloquent\BaseRepository;

class ClassLevelRepository extends BaseRepository
{
	public function model()
	{
		return ClassLevel::class;
	}
}