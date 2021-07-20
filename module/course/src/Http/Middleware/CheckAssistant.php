<?php
/**
 * Created by PhpStorm.
 * User: train
 * Date: 25/09/2018
 * Time: 14:22
 */

namespace Course\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Course\Models\Course;

class CheckAssistant
{
    public function handle($request, Closure $next)
    {
        $userId = Auth::id();
        $course = Course::find($request->id);

        if (empty($course)) {
            return redirect()->back();
        }

        $course = Course::find($course->id);

        if ($userId != 1 &&  $userId != $course->assistant && $userId != $course->author) {
            return redirect()->back()->withErrors('Bạn không có quyền phụ trách Khóa đào tạo này');
        }

        return $next($request);
    }
}