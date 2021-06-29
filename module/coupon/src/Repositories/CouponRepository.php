<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 5:48 PM
 */

namespace Coupon\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Coupon\Models\Coupon;

class CouponRepository extends BaseRepository
{
    public function model()
    {
        return Coupon::class;
    }

    function getCoupon($where)
    {
        $coupons = $this->all();
        return $coupons;
    }
}