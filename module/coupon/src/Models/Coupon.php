<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/10/2018
 * Time: 11:06 AM
 */

namespace Coupon\Models;

use Course\Models\Course;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupon';
    protected $guarded = [];
    protected $fillable = [
        'code', 'course', 'price', 'reamain', 'deadline', 'author', 'status', 'created_at', 'updated_at'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course');
    }

}