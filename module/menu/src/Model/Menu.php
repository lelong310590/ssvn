<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 8/1/2018
 * Time: 12:03 PM
 */

namespace Menu\Model;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';
    protected $fillable = [
        'name', 'slug', 'created_at', 'updated_at'
    ];
}