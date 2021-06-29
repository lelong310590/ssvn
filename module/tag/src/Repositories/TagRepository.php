<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/10/2018
 * Time: 2:58 PM
 */

namespace Tag\Repositories;

use Tag\Models\Tag;
use Prettus\Repository\Eloquent\BaseRepository;

class TagRepository extends BaseRepository
{
	public function model()
	{
		// TODO: Implement model() method.
		return Tag::class;
	}
}