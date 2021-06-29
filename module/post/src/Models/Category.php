<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/27/2018
 * Time: 2:59 PM
 */

namespace Post\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    protected $fillable = [
        'id', 'name', 'slug', 'parent', 'status', 'seo_title', 'seo_description', 'seo_keywords',
        'created_at', 'updated_at'
    ];

    public function getParentName(){
        $parname = '';
        if($this->parent>0){
            $parent = $this->find($this->parent);
            $parname = $parent->name;
        }

        return $parname;
    }
}