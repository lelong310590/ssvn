<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/31/2017
 * Time: 10:39 PM
 */

namespace Course\Http\Middleware;

use Cart\Models\OrderDetail;
use Closure;
use Course\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckCourse
{
    public function handle($request, Closure $next)
    {
        $slug = $request->slug;

        if (!Auth::check()) {
            return redirect(route('front.course.buy.get', ['slug' => $slug]));
        }

        $course = DB::table('course')
            ->select('id', 'author')
            ->where('slug', '=', $slug)
            ->where('status', '=', 'active')
            ->first();

        if (empty($course)) {
            return redirect(route('front.home.index.get'));
        }

        $userId = Auth::id();

        $course = Course::find($course->id);
        if (!$course->checkBought())
            return redirect(route('front.course.buy.get', ['slug' => $slug]));

        if ($course->getCurriculum->count() == 0) {
            return redirect()->back();
        }
        
        foreach ($course->getCurriculum as $item) {
            $process = DB::table('curriculum_progress')
                ->where([
                    ['course_id', $course->id],
                    ['curriculum_id', $item->id],
                    ['student', $userId],
                ])
                ->doesntExist();

            if ($process) {
                DB::table('curriculum_progress')
                    ->insert([
                        'course_id' => $course->id,
                        'curriculum_id' => $item->id,
                        'student' => $userId,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
            }
        }
        return $next($request);
    }
}