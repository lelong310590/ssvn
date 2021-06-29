<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 6/14/2018
 * Time: 1:54 PM
 */

namespace Course\Models;

use Illuminate\Database\Eloquent\Model;
use Users\Models\Users;

class TestResult extends Model
{
    protected $table = 'test_result';
    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(Users::class, 'owner');
    }

    public function lecture()
    {
        return $this->belongsTo(CourseCurriculumItems::class, 'lecture_id');
    }
}