<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/10/2018
 * Time: 2:14 PM
 */

namespace Course\Repositories;

use Course\Models\CourseLdp;
use Prettus\Repository\Eloquent\BaseRepository;

class CourseLdpRepository extends BaseRepository
{
	public function model()
	{
		return CourseLdp::class;
	}

	public function removePromoVideo($id)
    {
        return $this->update([
            'video_promo' => null
        ], $id);
    }
}