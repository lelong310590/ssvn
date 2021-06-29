<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/9/2018
 * Time: 4:08 PM
 */

namespace Course\Http\Controllers;

use Coupon\Models\Coupon;
use Course\Repositories\CourseRepository;
use Barryvdh\Debugbar\Controllers\BaseController;
use PriceTier\Repositories\PriceTierRepository;
use Illuminate\Http\Request;
use Coupon\Repositories\CouponRepository;

class CoursePriceController extends BaseController
{
    public function getIndex($id, CourseRepository $courseRepository,
                             PriceTierRepository $priceTierRepository, CouponRepository $couponRepository, Request $request)
    {
        $course = $courseRepository->find($id);
        $priceTier = $priceTierRepository->all();

        $coupon = Coupon::where('course', $id);
        if (empty($request->disable)) {
            $coupon = $coupon->where('status', 'active')->where('deadline', '>', date('Y-m-d H:i:s'));
        }
        if (!empty($request->q)) {
            $coupon = $coupon->where('code', 'LIKE', '%' . $request->q . '%');
        }
        $coupon = $coupon->orderBy('status')->orderBy('deadline')->paginate(20);
        //$coupon = $couponRepository->findWhere($conArr)->paginate(10);
        return view('nqadmin-course::backend.courseprice.index', [
            'course' => $course,
            'priceTier' => $priceTier,
            'coupon' => $coupon
        ]);
    }

    public function save(Request $request, $id, CourseRepository $courseRepository)
    {
        $price = $request->price;
        $approve_sale_system = $request->approve_sale_system;
        $courseRepository->update([
            'price' => $price,
            'approve_sale_system' => $approve_sale_system
        ], $id);

        return redirect()->back();
    }
}