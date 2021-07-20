<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/31/2017
 * Time: 10:39 PM
 */

namespace Course\Http\Middleware;

use Cart\Models\Order;
use Cart\Models\OrderDetail;
use Cart\Models\UserSubject;
use Closure;
use Course\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckCourseActive
{
    public function handle($request, Closure $next)
    {
        $slug = $request->slug;
        $course = DB::table('course')
            ->select('id', 'author')
            ->where('slug', '=', $slug)
            ->where('status', '=', 'active')
            ->first();

        if (empty($course)) {
            return redirect(route('front.home.index.get'));
        }

        if (Auth::check()) {
            $course = Course::with('getSubject')->find($course->id);
            $subject = $course->getSubject->count() > 0 ? $course->getSubject->first()->id : null;
            $user = auth('nqadmin')->user();
            if (!$course->checkBought() && $course->price == 0) {
                $order = Order::create([
                    'customer' => Auth::user()->id,
                    'total_price' => 0,
                    'payment_method' => 'direct',
                    'status' => 'done',
                ]);

                OrderDetail::create([
                    'order_id' => $order->id,
                    'course_id' => $course->id,
                    'author' => $course->owner->id,
                    'customer' => Auth::user()->id,
                    'price' => 0,
                    'base_price' => 0,
                    'coupon_id' => null,
                    'status' => 'done',
                ]);

                //insert to usersubject for stats
                $registered = UserSubject::where([
                    ['user', '=', auth('nqamin')->id()],
                    ['subject', '=', $subject],
                    ['company', '=', $user->classlevel],
                    ['type' , '=', 'personal']
                ]);

                if ($registered->count() == 0) {
                    UserSubject::create([
                        'user'  => auth('nqamin')->id(),
                        'subject' => $subject,
                        'company' => $user->classlevel,
                        'type' => 'personal'
                    ]);
                }

                $companyRegister = UserSubject::where([
                    ['subject', '=', $subject],
                    ['company', '=', $user->classlevel],
                    ['type' , '=', 'enterprise']
                ]);

                if ($companyRegister->count() == 0) {
                    UserSubject::create([
                        'subject' => $subject,
                        'company' => $user->classlevel,
                        'type' => 'enterprise'
                    ]);
                }
            }
        }

        return $next($request);
    }
}