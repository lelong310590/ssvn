<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 10:44 AM
 */

namespace Cart\Models;

use Coupon\Models\Coupon;
use Course\Models\Course;
use Course\Models\CourseCurriculumItems;
use Illuminate\Database\Eloquent\Model;
use Users\Models\Users;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    protected $fillable = [
        'order_id',
        'course_id',
        'author',
        'customer',
        'price',
        'base_price',
        'coupon_id',
        'status',
        'last_curriculum_id'
    ];

    /**
     * Relation 1 - 1 with Order
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function getAuthor()
    {
        return $this->belongsTo(Users::class, 'author');
    }

    public function getCustomer()
    {
        return $this->belongsTo(Users::class, 'customer');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function getCurriculumItems()
    {
        return $this->belongsTo(CourseCurriculumItems::class, 'last_curriculum_id');
    }
}