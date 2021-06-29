<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 12:15 AM
 */

namespace Cart\Http\Controllers;

use Base\Mail\CheckoutSuccess;
use Cart\Models\Order;
use Barryvdh\Debugbar\Controllers\BaseController;
use Cart\Models\OrderDetail;
use Cart\Repositories\OrdersRepository;
use Cart\Services\CartServices;
use ClassLevel\Models\ClassLevel;
use Course\Models\Course;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Base\Supports\FlashMessage;
use Illuminate\Support\Facades\Mail;
use Subject\Models\Subject;
use Users\Models\Users;
use Users\Repositories\UsersRepository;

class CartController extends BaseController
{
    protected $order;
    protected $user;
    public function __construct(OrdersRepository $ordersRepository, UsersRepository $usersRepository)
    {
        $this->order =$ordersRepository;
        $this->user = $usersRepository;
    }

    public function getSetting()
    {
        return view('nqadmin-cart::backend.setting');
    }

    function index(Request $request)
    {
        if($request->get('email')){
            $keyword = $request->get('email');
            $user = $this->user->findWhere(['email'=>$keyword])->first();
            if($user) {
                $datas = $this->order->with(['getCustomer'])->scopeQuery(function ($q) use ($keyword, $user) {
                    return $q->where(['customer' => $user->id]);
                })->paginate(25);
            }else{$datas = [];}
        }
        $datas = Order::with('getCustomer')->whereHas('detail', function ($query) {
            $query->where('base_price', '>', '0');
        });
        if ($request->payment_method && $request->payment_method != 'all') {
            $datas = $datas->where('payment_method', $request->payment_method)->paginate(25);
        }

        $datas = $datas->orderBy('created_at', 'desc')->paginate(25);
        return view('nqadmin-cart::backend.index', [
            'datas' => $datas
        ]);
    }

    function create(Request $request)
    {
        $users = new Users();
        if (!empty($request->user_id)) {
            $users = $users->where('id', $request->user_id);
            foreach (Cart::content() as $data) {
                $course = Course::find($data->id);
                if ($course->checkBoughtWithId($request->user_id)) {
                    CartServices::removeFromCart($data->rowId);
                }
            }
        }
        $users = $users->with('data')->get();

        $classlevels = ClassLevel::all();
        $subjects = Subject::all();

        $course = Course::where('status', 'active');
        if ($request->author) {
            $course = $course->where('author', $request->author);
        }
        if ($request->keyword) {
            $course = $course->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhereHas('getLdp', function ($query) use ($request) {
                    $query->where('excerpt', 'like', '%' . $request->keyword . '%')
                        ->orWhere('description', 'like', '%' . $request->keyword . '%');
                });
        }
        if ($request->keyword) {
            $course = $course->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhereHas('getLdp', function ($query) use ($request) {
                    $query->where('excerpt', 'like', '%' . $request->keyword . '%')
                        ->orWhere('description', 'like', '%' . $request->keyword . '%');
                });
        }
        if ($request->classlevel) {
            $course = $course->WhereHas('getLdp', function ($query) use ($request) {
                $query->where('classlevel', $request->classlevel);
            });
        }
        if ($request->subject) {
            $course = $course->WhereHas('getLdp', function ($query) use ($request) {
                $query->where('classlevel', $request->subject);
            });
        }
        $course = $course->with('getRating')->with('getClassLevel')->with(['getCurriculum' => function ($query) {
            $query->with('getMedia');
        }])->limit(20)->get();

        $discount = CartServices::checkCoupon($request->code);

        $currentUser = \Auth::user();
        $editable = $currentUser->can('user_edit');
        $deleteable = $currentUser->can('user_delete');
        return view('nqadmin-cart::backend.create', compact(
                'users',
                'classlevels',
                'course',
                'subjects',
                'discount',
                'currentUser',
                'editable',
                'deleteable'
            )
        );
    }

    function store(Request $request)
    {
        $users = Users::find($request->user_id);
        if (!empty($users)) {
            $total_amount = Cart::content()->sum('price');

            $discount_amount = $request->code ? CartServices::checkCoupon($request->code) : 0;

            $order = Order::create([
                'customer' => $users->id,
                'total_price' => $total_amount - $discount_amount['price'],
                'payment_method' => $request->payment_method,
                'status' => 'create',
            ]);
            foreach (Cart::content() as $data) {
                $price = $data->price;
                $coupon_id = null;
                if (!empty($request->khuyenmai) && in_array($data->id, $request->khuyenmai)) {
                    $price = 0;
                } else {
                    if ($data->id == $discount_amount['course_id']) {
                        $price = $data->price - $discount_amount['price'];
                        $coupon_id = $discount_amount['coupon_id'];
                    }
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

            Mail::to($users)->queue(new CheckoutSuccess($users, $order));
        } else {
            return redirect(route('nqadmin::checkout.index.get'))->with('error', 'Có lỗi sảy ra! phiền bạn thanh toán lại!');
        }
        return redirect(route('nqadmin::checkout.index.get'))->with('success', 'bạn đã mua Khóa đào tạothành công!');
    }

    function show($id)
    {
        $data = Order::find($id);
        return view('nqadmin-cart::backend.show', compact('data'));
    }

    function update($id, Request $request)
    {
        $order = Order::find($id);
        $order->done();
        $order->payment_method = $request->payment_method;
        $order->save();
        return redirect()->back();
    }

    public function postAddToCart(Request $request)
    {
        $return = CartServices::checkCourse($request->course_id, true);
        $return['html'] = '';
        if ($return['code']) {
            $course = Course::find($request->course_id);
            CartServices::addToCart($course->id, $course->name, $course->price);
            $return['html'] = view('nqadmin-cart::backend.components.checkout', ['request' => $request])->render();
        }
        return $return;
    }

    public function postRemoveToCart(Request $request)
    {
        $rowId = $request->course_id;

        CartServices::removeFromCart($rowId);

        $html = view('nqadmin-cart::backend.components.checkout')->render();
        $return = [
            'html' => $html,
            'message' => FlashMessage::returnMessage('create'),
            'code' => 1
        ];
        return $return;
    }
}