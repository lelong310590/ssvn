<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/12/2018
 * Time: 11:47 AM
 */

namespace Course\Repositories;

use Course\Models\CourseTarget;
use Prettus\Repository\Eloquent\BaseRepository;

class CourseTargetRepository extends BaseRepository
{
	public function model()
	{
		return CourseTarget::class;
	}
}