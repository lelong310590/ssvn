<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/12/2018
 * Time: 11:41 AM
 */

namespace Advertise\Models;

use Course\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Users\Models\Users;

class Advertise extends Model
{
    protected $table = 'advertise';
    protected $fillable = [
        'author_id',
        'course_id',
        'title',
        'content',
        'answer_id',
        'type',
        'status',
        'created_at',
        'updated_at',
    ];

    public function getAuthor()
    {
        return $this->belongsTo(Users::class, 'author_id');
    }

    public function getCourses()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function getUsers()
    {
        return $this->belongsToMany(Users::class, (new AdvertiseUser())->getTable(), 'advertise_id', 'user_id');
    }
}