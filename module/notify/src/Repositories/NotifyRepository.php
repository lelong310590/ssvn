<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/10/2018
 * Time: 11:13 AM
 */

namespace Notify\Repositories;

use Notify\Models\Notify;
use Prettus\Repository\Eloquent\BaseRepository;

class NotifyRepository extends BaseRepository
{
	public function model()
	{
		return Notify::class;
	}

}