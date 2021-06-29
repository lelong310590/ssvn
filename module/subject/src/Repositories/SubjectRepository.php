<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 5:48 PM
 */

namespace Subject\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Subject\Models\Subject;

class SubjectRepository extends BaseRepository
{
	public function model()
	{
		return Subject::class;
	}
}