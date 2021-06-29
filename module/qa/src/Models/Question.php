<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/10/2018
 * Time: 11:06 AM
 */

namespace Qa\Models;

use Course\Models\CourseCurriculumItems;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Users\Models\Users;
use Course\Models\Course;

class Question extends Model
{
    protected $table = 'question';
    protected $guarded = [];
    protected $fillable = [
        'title', 'content', 'report', 'readed', 'course', 'created_at', 'updated_at', 'published_at', 'author', 'lecture'
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
        return $this->belongsTo(Users::class, 'author');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getCourse()
    {
        return $this->belongsTo(Course::class, 'course');
    }

    public function getLecture()
    {
        return $this->belongsTo(CourseCurriculumItems::class, 'lecture');
    }

    public function getAnswer()
    {
        return $this->hasMany(Answer::class, 'question');
    }
}