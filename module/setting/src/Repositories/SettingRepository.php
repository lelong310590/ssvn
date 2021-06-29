<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/10/2018
 * Time: 11:13 AM
 */

namespace Setting\Repositories;

use Setting\Models\Setting;
use Prettus\Repository\Eloquent\BaseRepository;

class SettingRepository extends BaseRepository
{
	public function model()
	{
		return Setting::class;
	}

}