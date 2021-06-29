<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/12/2018
 * Time: 3:40 PM
 */

namespace Cart\Repositories;

use Cart\Models\OrderDetail;
use Prettus\Repository\Eloquent\BaseRepository;

class OrderDetailsRepository extends BaseRepository
{
    public function model()
    {
        return OrderDetail::class;
    }

}