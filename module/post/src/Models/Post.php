<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/30/2018
 * Time: 4:57 PM
 */

namespace Post\Models;

use Illuminate\Database\Eloquent\Model;
use Users\Models\Users;

class Post extends Model
{
    protected $table = 'post';
    protected $fillable = [
        'name', 'slug', 'content', 'thumbnail', 'author', 'post_type', 'template', 'created_at', 'updated_at', 'seo_title',
        'seo_keywords', 'seo_description', 'excerpt'
    ];

    public function getAuthor()
    {
        return $this->belongsTo(Users::class, 'author', 'id');
    }


}