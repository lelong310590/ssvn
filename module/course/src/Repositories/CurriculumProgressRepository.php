<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/10/2018
 * Time: 11:13 AM
 */

namespace Course\Repositories;

use Course\Models\CurriculumProgress;
use Prettus\Repository\Eloquent\BaseRepository;

class CurriculumProgressRepository extends BaseRepository
{
	public function model()
	{
		return CurriculumProgress::class;
	}
}