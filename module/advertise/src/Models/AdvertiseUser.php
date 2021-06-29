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

class AdvertiseUser extends Model
{
    protected $table = 'advertise_user';
    protected $fillable = [
        'advertise_id',
        'user_id',
        'status',
        'created_at',
        'updated_at',
    ];
}