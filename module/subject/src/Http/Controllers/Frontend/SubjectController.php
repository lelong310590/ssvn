<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/27/2018
 * Time: 4:19 PM
 */

namespace Subject\Http\Controllers\Frontend;

use ClassLevel\Models\ClassLevel;
use Course\Models\Course;
use Course\Models\CourseLdp;
use Subject\Models\Subject;

class SubjectController
{
    public function getSubject($class, $subject)
    {
        $cl = ClassLevel::select(['id', 'name'])->where('slug', $class)->get()->first();
        $sb = Subject::select(['id', 'name', 'seo_title', 'seo_description', 'seo_keywords'])->where('slug', $subject)->get()->first();
        if ($cl && $sb) {
            $clId = $cl->id;
            $sbId = $sb->id;
            $course = Course::where('status', 'active')
                ->whereHas('getLdp', function ($query) use ($clId, $sbId) {
                    $query->where('classlevel', $clId)
                        ->where('subject', $sbId);
                })->paginate(5);

            return view('nqadmin-subject::frontend.index', [
                'course' => $course,
                'class' => $cl,
                'subject' => $sb
            ]);
        } else {
            return redirect(route('front.home.index.get'));
        }
    }
}