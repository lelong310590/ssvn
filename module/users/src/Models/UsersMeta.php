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

class UsersMeta extends Model
{
    protected $fillable = ['users_id', 'meta_key', 'meta_value', 'status'];

    /**
     * Relation n - 1 with User
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Users::class);
    }
}