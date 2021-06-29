<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/12/2018
 * Time: 3:40 PM
 */

namespace Cart\Repositories;

use Cart\Models\Order;
use Prettus\Repository\Eloquent\BaseRepository;

class OrdersRepository extends BaseRepository
{
    public function model()
    {
        return Order::class;
    }

    public function getProfitByMonth($month)
    {
        return $this->scopeQuery(function ($q) use ($month) {
            return $q->where('payment_method', 'transfer')->whereMonth('created_at', '=', $month)->whereYear('created_at', '=', intval(date("Y")));
        })->all(['id', 'total_price'])->sum('total_price');
    }

    public function getOrderInMonth()
    {
        $month = intval(date("m"));
        return $this->scopeQuery(function ($q) use ($month) {
            return $q->where('payment_method', 'transfer')->whereMonth('created_at', '=', $month)->whereYear('created_at', '=', intval(date("Y")));
        })->all(['id'])->count();
    }

}