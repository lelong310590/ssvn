<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/12/2018
 * Time: 11:41 AM
 */

namespace Messages\Models;

use Illuminate\Database\Eloquent\Model;
use Users\Models\Users;

class MessageDetail extends Model
{
    protected $table = 'message_details';
    protected $fillable = [
        'sender',
        'message_id',
        'message',
        'status',
        'created_at',
        'updated_at',
    ];

    public function getSender()
    {
        return $this->belongsTo(Users::class, 'sender');
    }
}