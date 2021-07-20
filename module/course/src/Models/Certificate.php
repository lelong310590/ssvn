<?php
/**
 * Certificate.php
 * Created by: trainheartnet
 * Created at: 08/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Course\Models;

use Illuminate\Database\Eloquent\Model;
use Subject\Models\Subject;

class Certificate extends Model
{
    protected $table = 'certificate';

    protected $fillable = [
        'user_id',
        'course_id',
        'created_at',
        'updated_at',
        'image',
        'subject_id',
        'company_id',
        'province',
        'district',
        'ward',
        'type'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}