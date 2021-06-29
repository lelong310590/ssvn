<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 5:48 PM
 */

namespace Qa\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Qa\Models\Question;

class QuestionRepository extends BaseRepository
{
	public function model()
	{
		return Question::class;
	}
}