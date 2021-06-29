<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/27/2018
 * Time: 4:13 PM
 */

namespace ClassLevel\Http\Controllers\Frontend;

use Barryvdh\Debugbar\Controllers\BaseController;
use ClassLevel\Models\ClassLevel;
use Course\Models\Course;
use Course\Models\CourseLdp;

class ClassLevelController extends BaseController
{
    public function getClass($slug)
    {
        $cl = ClassLevel::select(['id', 'name', 'seo_title', 'seo_keywords', 'seo_description'])->where('slug', $slug)->get()->first();
        if ($cl) {
            $clId = $cl->id;
            $course = Course::where('status', 'active')
                ->whereHas('getLdp', function ($query) use ($clId) {
                    $query->where('classlevel', $clId);
                })->paginate(5);

            return view('nqadmin-classlevel::frontend.index', [
                'course' => $course,
                'class' => $cl
            ]);
        } else {
            return redirect(route('front.home.index.get'));
        }
    }
}