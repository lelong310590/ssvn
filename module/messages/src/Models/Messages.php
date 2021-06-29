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

class Messages extends Model
{
    protected $table = 'messages';
    protected $fillable = [
        'sender',
        'receiver',
        'status',
        'created_at',
        'updated_at',
    ];

    public function getMessageInList()
    {
        return $this->hasMany(MessageLists::class, 'message_id');
    }

    public function getSender()
    {
        return $this->belongsTo(Users::class, 'sender');
    }

    public function getReceiver()
    {
        return $this->belongsTo(Users::class, 'receiver');
    }

    public function getDetail()
    {
        return $this->hasMany(MessageDetail::class, 'message_id');
    }
}