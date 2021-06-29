<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/10/2018
 * Time: 11:06 AM
 */

namespace Rating\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Users\Models\Users;
use Course\Models\Course;

class Rating extends Model
{
    protected $table = 'rating';
    protected $guarded = [];
    protected $fillable = [
        'rating_number', 'content', 'course', 'author', 'answer',
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
    public function getcourse()
    {
        return $this->belongsTo(Course::class, 'course');
    }


}