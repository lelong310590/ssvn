<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/12/2018
 * Time: 11:41 AM
 */

namespace Advertise\Models;

use Illuminate\Database\Eloquent\Model;
use Users\Models\Users;

class AdvertiseCourse extends Model
{
    protected $table = 'advertise_course';
    protected $fillable = [
        'advertise_id',
        'course_id',
        'status',
        'created_at',
        'updated_at',
    ];
}