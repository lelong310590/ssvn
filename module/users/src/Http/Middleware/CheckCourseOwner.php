<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/31/2017
 * Time: 10:39 PM
 */

namespace Users\Http\Middleware;

use Cart\Models\OrderDetail;
use Closure;
use Course\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckCourseOwner
{
    public function handle($request, Closure $next)
    {
        $userId = Auth::id();

        $course = Course::find($request->id);
        if (empty($course) || $course->owner->id != $userId) {
            return redirect(route('front.home.index.get'));
        }

        return $next($request);
    }
}