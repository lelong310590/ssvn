<?php
/**
 * Created by PhpStorm.
 * User: sonk5
 * Date: 6/23/2018
 * Time: 10:16 AM
 */

namespace Cart\Services;


use Coupon\Models\Coupon;
use Course\Models\Course;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartServices
{
    static function checkCourse($course_id, $is_admin = false)
    {
        $course = Course::find($course_id);
        $message = 'Không tồn tại sản phẩm';
        $check = false;
        if ($course) {
            $message = 'Đã thêm Khóa đào tạo' . $course->name . ' vào giỏ hàng';
            $check = true;
            foreach (Cart::content() as $content) {
                if ($content->id == $course->id) {
                    $message = 'Khóa đào tạođã tồn tại trong giỏ hàng';
                    $check = false;
                    break;
                }
            }
            if (!$is_admin) {
                if (\Auth::check() && $course->checkBought()) {
                    $message = 'Khóa đào tạođã được mua, xin mời học';
                    $check = false;
                }
            }
        }
        $alert = view('nqadmin-dashboard::frontend.partials.flash-message-backup', ['key' => $check ? 'success' : 'error', 'message' => $message])->render();
        return ['code' => $check, 'message' => $message, 'alert' => $alert];
    }

    static function addToCart($course_id, $course_name, $course_price)
    {
        if (\Auth::check()) {
            Cart::restore(\Auth::user()->email);
        }

        Cart::add($course_id, $course_name, 1, $course_price ? $course_price : 0);

        if (\Auth::check()) {
            Cart::store(\Auth::user()->email);
        }
    }

    static function updateCart($rowId, $course_id, $course_name, $course_price)
    {
        if (\Auth::check()) {
            Cart::restore(\Auth::user()->email);
        }

        Cart::update($rowId, ['id' => $course_id, 'name' => $course_name, 'price' => $course_price]);

        if (\Auth::check()) {
            Cart::store(\Auth::user()->email);
        }
    }

    static function removeFromCart($cartId)
    {
        if (\Auth::check()) {
            Cart::restore(\Auth::user()->email);
        }

        Cart::remove($cartId);

        if (\Auth::check()) {
            Cart::store(\Auth::user()->email);
        }

        $message = 'Đã xóa Khóa đào tạokhỏi giỏ hàng';
        $alert = view('nqadmin-dashboard::frontend.partials.flash-message-backup', ['key' => 'success', 'message' => $message])->render();
        return ['code' => true, 'message' => $message, 'alert' => $alert];
    }

    static function removeAllFromCart()
    {
        if (\Auth::check()) {
            Cart::restore(\Auth::user()->email);
        }

        Cart::destroy();

        if (\Auth::check()) {
            Cart::store(\Auth::user()->email);
        }
    }

    static function checkCoupon($coupon)
    {
        $message = 'Mã Coupon không đúng hoặc hết hạn';
        $course_id = 0;
        $price = 0;
        $coupon_id = 0;

        $coupon = Coupon::where('code', $coupon)
            ->where('deadline', '>', date('Y-m-d H:i:s'))
            ->where('reamain', '>', 0)
            ->first();
        if ($coupon) {
            if (Cart::content()->where('id', $coupon->course)->count()) {
                $message = 'Thành công';
                $course_id = $coupon->course;
                $price = $coupon->price;
                $coupon_id = $coupon->id;
            }
        }
        return ['course_id' => $course_id, 'message' => $message, 'price' => $price, 'coupon_id' => $coupon_id];
    }
}