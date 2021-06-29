<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/6/2018
 * Time: 11:33 PM
 */

namespace Level\Http\Controllers\Frontend;

use Barryvdh\Debugbar\Controllers\BaseController;
use Course\Models\Course;
use Level\Repositories\LevelRepository;
use Level\Models\Level;
use Course\Models\CourseLdp;

class LevelController extends BaseController
{
    protected $repository;

    public function __construct(LevelRepository $levelRepository)
    {
        $this->repository = $levelRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList($slug)
    {
        $lv = Level::where('slug', $slug)->get()->first();
        if ($lv) {
            $lvId = $lv->id;
            $course = Course::where('status', 'active')
                ->whereHas('getLdp', function ($query) use ($lvId) {
                    $query->where('level', $lvId);
                })->paginate(5);

            return view('nqadmin-level::frontend.index', [
                'course' => $course
            ]);
        } else {
            return redirect(route('front.home.index.get'));
        }
    }
}