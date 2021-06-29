<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/6/2017
 * Time: 10:45 PM
 */

namespace Users\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Users\Models\Users;

class UsersRepository extends BaseRepository
{
	public function model()
	{
		return Users::class;
	}

    /**
     * @return mixed
     */
    public function getActiveUserInMonth()
    {
        $month = intval(date("m"));
        return $this->scopeQuery(function ($q) use ($month) {
            return $q->where('status', 'active')->whereMonth('created_at', '=', $month)->whereYear('created_at', '=', intval(date("Y")));
        })->all(['id'])->count();
    }
}