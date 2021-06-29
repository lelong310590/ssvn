<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/12/2018
 * Time: 3:38 PM
 */

namespace Course\Models;

use Cart\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Media\Models\Media;
use Auth;
use Illuminate\Support\Facades\DB;
use MultipleChoices\Models\Question;

class CourseCurriculumItems extends Model
{
    protected $table = 'course_curriculum_items';
    protected $guarded = [];

    /**
     * @param $val
     */
    public function setCourseIdAttribute($val)
    {
        $this->attributes['course_id'] = intval($val);
    }

    /**
     * Relation ship 1 - 1 with course
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getCourse()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function getMedia()
    {
        return $this->hasMany(Media::class, 'curriculum_item');
    }

    public function getChildCurriculum()
    {
        return $this->hasMany(CourseCurriculumItems::class, 'parent_section');
    }

    public function getParentCurriculum()
    {
        return $this->belongsTo(CourseCurriculumItems::class, 'parent_section');
    }

    public function getLession($keyword = null)
    {
        $lessions = $this->where('parent_section', $this->id)
            ->where('status', 'active')
            ->whereNotIn('type', ['section']);

        if (!empty($keyword)) {
            $lessions = $lessions->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhereHas('getMedia', function ($q) use ($keyword) {
                        $q->where('url', 'like', '%' . $keyword . '%');
                    });
            });
        }

        return $lessions->with('getMedia')->with('getProcess')->get();
    }

    public function getProcess()
    {
        return $this->hasMany(CurriculumProgress::class, 'curriculum_id');
    }

    public function getFinishItem()
    {
        $return = 0;
        foreach ($this->getChildCurriculum as $item) {
            $check = $item->getProcess->where('status', 3)->where('student', Auth::id())->count();
            $return += $check;
        }
        return $return;
    }

    public function checkFinish()
    {
        return isset($this->getProcess->where('student', Auth::id())->first()->status) ? $this->getProcess->where('student', Auth::id())->first()->status : 0;
    }

    public function updateLastCurriculum()
    {
        $temp = OrderDetail::where('course_id', $this->course_id)->where('customer', Auth::id())->first();
        if ($temp) {
            $temp->last_curriculum_id = $this->id;
            $temp->save();

            return true;
        } else {
            return false;
        }
    }

    /**
     * @return int
     */
    public function checkVideoCount()
    {
        return $this->getMedia->where('type', 'video/mp4')->count();
    }

    public function getAllQuestion()
    {
        return $this->hasMany(Question::class, 'curriculum_item', 'id');
    }
}