<?php
/**
 * Certificate.php
 * Created by: trainheartnet
 * Created at: 08/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Course\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $table = 'certificate';

    protected $fillable = [
        'user_id',
        'course_id',
        'created_at',
        'updated_at',
        'image'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}