<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/12/2018
 * Time: 11:16 AM
 */

namespace Course\Models;

use Illuminate\Database\Eloquent\Model;

class CourseTarget extends Model
{
    protected $table = 'course_target';
    protected $guarded = [];
    protected $fillable = [
        'course_id', 'target', 'created_at', 'updated_at'
    ];

    /**
     * Relation ship 1 - 1 with course
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getCourse()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * Set default value type for target field
     * @param $value
     */
    public function setTargetAttribute($value)
    {
        $target = json_encode($value);
        $this->attributes['target'] = $target;
    }

    public function getTargetAttribute($value)
    {
        return json_decode($value);
    }
}