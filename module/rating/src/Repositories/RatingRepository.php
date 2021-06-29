<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 5:48 PM
 */

namespace Rating\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Rating\Models\Rating;

class RatingRepository extends BaseRepository
{
	public function model()
	{
		return Rating::class;
	}
}