<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/12/2018
 * Time: 11:41 AM
 */

namespace Messages\Models;

use Illuminate\Database\Eloquent\Model;

class MessageLists extends Model
{
    protected $table = 'message_lists';
    protected $fillable = [
        'user_id',
        'message_id',
        'seen',
        'type',
        'status',
        'created_at',
        'updated_at',
    ];

    public function getMessage()
    {
        return $this->belongsTo(Messages::class, 'message_id');
    }
}