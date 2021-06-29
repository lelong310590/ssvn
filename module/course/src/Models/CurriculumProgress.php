<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/10/2018
 * Time: 11:06 AM
 */

namespace Course\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Users\Models\Users;

class CurriculumProgress extends Model
{
	protected $table = 'curriculum_progress';
	protected $guarded = [];
	protected $fillable = [
		'course_id', 'curriculum_id', 'student', 'progress', 'status', 'created_at', 'updated_at', 'published_at','detail'
	];
	
	/**
	 * Convert string timestrap to Carbon obj
	 * @param $value
	 */
	public function setPublishedAtAttribute($value)
	{
		$published_at = strtotime(str_replace('/', '-', $value));
		$published_at = Carbon::createFromTimestamp($published_at);
		$this->attributes['published_at'] = $published_at;
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function owner()
	{
		return $this->belongsTo(Users::class, 'student');
	}

    public function getCurriculum()
    {
        return $this->belongsTo(CourseCurriculumItems::class, 'curriculum_id');
    }

    public function getCourse()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}