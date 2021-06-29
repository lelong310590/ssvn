<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 8/1/2018
 * Time: 1:45 PM
 */

namespace Menu\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Menu\Model\MenuNode;

class MenuNodeRepository extends BaseRepository
{
    public function model()
    {
        return MenuNode::class;
    }
}