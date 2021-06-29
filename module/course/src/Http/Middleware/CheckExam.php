<?php
/**
 * Created by PhpStorm.
 * User: train
 * Date: 17/11/2018
 * Time: 11:59
 */
namespace Course\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Course\Models\Course;

class CheckExam
{
    public function handle($request, Closure $next)
    {
        $slug = $request->slug;

        $course = Course::where('slug', $slug)->first();

        if (empty($course)) {
            return redirect(route('front.home.index.get'));
        }

        $type = $course->type;
        $time_start = strtotime($course->time_start);
        $end_start = strtotime($course->time_end);


        if ($type == 'exam' && $time_start > time()) { // Chua den gio thi
            return redirect(route('front.course.buy.get', $slug));
        }

//        //Check user da lam bai thi chua
//        if (Auth::check()) {
//            $user = Auth::user();
//            $courseId = $course->id;
//            $check = $user->checkDoExam($courseId);
//
//            if ($check) {
//                return redirect(route('front.course.buy.get', $slug));
//            }
//
//        } else {
//            return redirect(route('front.course.buy.get', $slug));
//        }


        return $next($request);
    }
}