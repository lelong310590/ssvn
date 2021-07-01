<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 10:29 AM
 */

namespace ClassLevel\Models;

use Course\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Subject\Models\Subject;
use Users\Models\Users;

class ClassLevel extends Model
{
    protected $table = 'classlevel';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'slug', 'group', 'seo_title', 'seo_description', 'seo_keywords', 'author', 'editor', 'status', 'publish',
        'updated_at', 'created_at', 'mst'
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

    function getGroupAttribute($value)
    {
        switch ($value) {
            case 'primary':
                return 'Tiểu học';
                break;
            case 'secondary':
                return 'Trung học cơ sở';
                break;
            case 'high':
                return 'Trung học phổ thông';
                break;
        }
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
    public function edit()
    {
        return $this->belongsTo(Users::class, 'editor');
    }

    public function subject()
    {
        return $this->belongsToMany(Subject::class, 'class_subject', 'class_id', 'subject_id');
    }

    public function course()
    {
        return $this->belongsToMany(Course::class, 'course_ldp', 'classlevel', 'course_id');
    }

    public function getUsers()
    {
        return $this->belongsTo(Users::class, 'classlevel', 'id');
    }
}