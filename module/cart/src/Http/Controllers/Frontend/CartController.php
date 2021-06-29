<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 12:15 AM
 */

namespace Cart\Http\Controllers\Frontend;

use Base\Mail\CheckoutSuccess;
use Base\Mail\CreateCheckout;
use Cart\Models\Order;
use Cart\Models\OrderDetail;
use Cart\Services\CartServices;
use Cart\Services\Nganluong;
use Barryvdh\Debugbar\Controllers\BaseController;
use Coupon\Models\Coupon;
use Course\Models\Course;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Base\Supports\FlashMessage;
use Auth;
use Illuminate\Support\Facades\Mail;

class CartController extends BaseController
{
    public function postAddToCart(Request $request)
    {
        $return = $this->actionAddToCart($request->course_id);
        if ($request->type == 'ajax')
            return response()->json($return, 200);
        else {
            if (!empty($request->couponCode)) {
                return redirect(route('front.cart.checkout.get', ['code' => $request->couponCode]));
            }
            return redirect(route('front.cart.checkout.get'));
        }
    }

    public function actionAddToCart($course_id)
    {
        $return = CartServices::checkCourse($course_id);
        $return['html'] = '';
        if ($return['code']) {
            $course = Course::find($course_id);
            CartServices::addToCart($course->id, $course->name, $course->price);
            $return['html'] = view('nqadmin-dashboard::frontend.components.header.dropdown.cart.list')->render();
        }
        return $return;
    }

    public function postRemoveToCart(Request $request)
    {
        $rowId = $request->course_id;

        $return = CartServices::removeFromCart($rowId);

        $return['html'] = view('nqadmin-dashboard::frontend.components.header.dropdown.cart.list')->render();
        return $return;
    }

    function getCheckout(Request $request)
    {
        $user = Auth::user();
        $discount = CartServices::checkCoupon($request->code);
        foreach (Cart::content() as $data) {
            $course = Course::find($data->id);
            CartServices::updateCart($data->rowId, $course->id, $course->name, $course->price);
        }
        return view('nqadmin-cart::frontend.checkout', [
            'user' => $user,
            'discount' => $discount
        ]);
    }

    function postSendPaymentFree($id, Request $request)
    {
        $users = \Auth::user();

        $course = Course::find($id);
        if (!empty($course) && $course->price == 0) {
            $order = Order::create([
                'customer' => $users->id,
                'total_price' => 0,
                'payment_method' => 'direct',
                'status' => 'done',
            ]);
            OrderDetail::create([
                'order_id' => $order->id,
                'course_id' => $id,
                'author' => $course->owner->id,
                'customer' => $users->id,
                'price' => 0,
                'base_price' => 0,
                'coupon_id' => null,
                'status' => 'done',
            ]);
            Mail::to($users)->queue(new CheckoutSuccess($users, $order));
            return redirect(route('front.course.buy.get', ['slug' => $course->slug]))->with('success', 'bạn đã tham gia Khóa đào tạothành công!');
        }
        return redirect(route('front.home.index.get'))->with('error', 'Có lỗi sảy ra, xin thử lại!');
    }

    function postSendPayment(Request $request)
    {
        $users = \Auth::user();

        $buyer_email = $users->email;
        $buyer_mobile = $users->getDataByKey('phone');

        $payment_method = $request->payment_method;

        if ($buyer_email == '') {
            return redirect(route('front.cart.checkout.get'))->with('error', 'Bạn chưa nhập địa chỉ Email');
        }
        if ($buyer_mobile == '') {
            return redirect(route('front.cart.checkout.get'))->with('error', 'Bạn chưa nhập Số điện thoại');
        }
        if ($payment_method == '') {
            return redirect(route('front.cart.checkout.get'))->with('error', 'Bạn chưa Chọn hình thức thanh toán');
        }

        $discount_amount = $request->code ? CartServices::checkCoupon($request->code) : 0;
        $total_amount = Cart::content()->sum('price');

        $order = Order::create([
            'customer' => $users->id,
            'total_price' => $total_amount - $discount_amount['price'],
            'payment_method' => $request->payment_method,
            'status' => 'create',
        ]);
        foreach (Cart::content() as $data) {
            $price = $data->price;
            $coupon_id = null;
            if ($data->id == $discount_amount['course_id']) {
                $price = $data->price - $discount_amount['price'];
                $coupon_id = $discount_amount['coupon_id'];
            }
            OrderDetail::create([
                'order_id' => $order->id,
                'course_id' => $data->id,
                'author' => Course::find($data->id)->owner->id,
                'customer' => $users->id,
                'price' => $price,
                'base_price' => $data->price,
                'coupon_id' => $coupon_id,
                'status' => 'create',
            ]);
        }

        CartServices::removeAllFromCart();

        Mail::to($users)->queue(new CreateCheckout($users, $order));

        if ($total_amount == $discount_amount) {
            Mail::to($users)->queue(new CheckoutSuccess($users, $order));
            $order->done();
            return redirect(route('front.users.my_course.get'))->with('success', 'bạn đã mua Khóa đào tạothành công!');
        } else {
            switch ($payment_method) {
                case 'transfer':
                case 'direct':
                    return redirect(route('front.users.history.get'))->with('success', 'Bạn đã thanh toán thành công, Chờ xác nhận từ quản trị viên!');
                    break;
                case 'atm':
                    return redirect(route('front.users.my_course.get'))->with('success', 'Sẽ có update sau!');
                    break;
            }
        }
        return redirect(route('front.home.index.get'))->with('error', 'Có lỗi sảy ra, xin thử lại!');
    }

    function getNganLuongCallback(Request $request)
    {
        if (isset($request->error_code) && isset($request->token)) {
            $nlcheckout = new Nganluong(config('cart.nganluong.merchant_id'), config('cart.nganluong.merchant_pass'), config('cart.nganluong.receiver'), config('cart.nganluong.url_api'));
            $nl_result = $nlcheckout->GetTransactionDetail($request->token);

            if ($nl_result) {
                $order = Order::where('token', $nl_result->token)->first();
                if ($order != null) {
                    if ($nl_errorcode == '00') {
                        if ($nl_transaction_status == '00') {
                            $user = $order->getCustomer;
                            Mail::to($user)->queue(new CheckoutSuccess($user, $order));
                            $order->done();
                        }
                    } else {
                        return redirect(route('home'))->with('error', $nlcheckout->GetErrorMessage($nl_errorcode));
                    }
                }
            }
        }
        return redirect(route('home'));
    }

    function getNganLuongCancel(Request $request)
    {
        return redirect(route('home'));
    }
}