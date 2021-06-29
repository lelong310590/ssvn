<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/10/2018
 * Time: 2:09 PM
 */

namespace Course\Models;

use ClassLevel\Models\ClassLevel;
use Illuminate\Database\Eloquent\Model;
use Level\Models\Level;
use Subject\Models\Subject;
use Tag\Models\Tag;

class CourseLdp extends Model
{
    protected $table = 'course_ldp';
    protected $guarded = [];
    protected $fillable = [
        'course_id', 'excerpt', 'description', 'classlevel', 'subject', 'level', 'thumbnail', 'video_promo',
        'created_at', 'updated_at'
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
     * Relation ship 1 - 1 with classlevel
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getClassLevel()
    {
        return $this->belongsTo(ClassLevel::class, 'classlevel');
    }

    public function getTag()
    {
        return $this->belongsToMany(Tag::class, 'course_tag', 'course_id', 'tag_id')->withTimestamps();
    }

    /**
     * Relation ship 1 - 1 with level
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getLevel()
    {
        return $this->belongsTo(Level::class, 'level');
    }

    /**
     * Relation ship 1 - 1 with subject
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getSubject()
    {
        return $this->belongsTo(Subject::class, 'subject');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getVideoPromoAttribute($value)
    {
        if (empty($value)) {
            $datas = $this->getCourse->getCurriculum->where('preview','active');
            foreach ($datas as $data) {
                $media = $data->getMedia->where('type', 'video/mp4')->first();
                if (!empty($media)) {
                    return $media->url;
                }
            }
        }
        return $value;
    }
}