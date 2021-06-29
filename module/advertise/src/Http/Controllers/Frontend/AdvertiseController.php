<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/27/2018
 * Time: 4:13 PM
 */

namespace Advertise\Http\Controllers\Frontend;

use Barryvdh\Debugbar\Controllers\BaseController;

class AdvertiseController extends BaseController
{
    public function update()
    {
        $advertises = \Auth::user()->getAdvertise()->where('advertise.status', 'active')->get();
        foreach ($advertises as $advertise) {
            $advertise->status = 'disable';
            $advertise->save();
        }
        return json_encode(['status' => 'success']);
    }
}