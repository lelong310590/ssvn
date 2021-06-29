<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 10:44 AM
 */

namespace Users\Models;

use Illuminate\Database\Eloquent\Model;
use Users\Models\Users;

class SocialAccounts extends Model
{
    protected $fillable = ['user_id', 'provider_user_id', 'provider'];

    /**
     * Relation 1 - 1 with User
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
}