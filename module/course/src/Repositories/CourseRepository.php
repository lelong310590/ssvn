<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/10/2018
 * Time: 11:13 AM
 */

namespace Course\Repositories;

use Course\Models\Course;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;

class CourseRepository extends BaseRepository
{
	public function model()
	{
		return Course::class;
	}

    /**
     * @return mixed
     */
    public function getCourseInMonth()
    {
        $month = intval(date("m"));
        return $this->scopeQuery(function ($q) use ($month) {
            return $q->where('status', 'active')->whereMonth('created_at', '=', $month)->whereYear('created_at', '=', intval(date("Y")));
        })->all(['id'])->count();
    }

    /**
     * @return mixed
     */
    public function getCourseInIndex()
    {
        $userID = auth()->id();
        if ($userID == 1) {
            return $this->with('getLdp')
                ->orderBy('created_at', 'desc')
                ->paginate(25);
        } else {
            return $this->with('getLdp')->scopeQuery(function ($q) {
                return $q->orderBy('created_at', 'desc')->where('author', auth()->id())->orWhere('assistant', auth()->id());
            })->paginate(25);
        }
    }

}