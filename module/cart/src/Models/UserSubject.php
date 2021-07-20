<?php
/**
 * UserSubject.php
 * Created by: trainheartnet
 * Created at: 20/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Cart\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubject extends Model
{
    protected $table = 'user_subject';

    protected $fillable = [
        'user',
        'subject',
        'company',
        'type',
        'created_at',
        'updated_at'
    ];
}