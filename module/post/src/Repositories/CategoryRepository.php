<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/27/2018
 * Time: 2:59 PM
 */

namespace Post\Repositories;

use Post\Models\Category;
use Prettus\Repository\Eloquent\BaseRepository;

class CategoryRepository extends BaseRepository
{
    public function model()
    {
        return Category::class;
    }

}