<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 8/1/2018
 * Time: 12:04 PM
 */

namespace Menu\Repositories;

use Menu\Model\Menu;
use Prettus\Repository\Eloquent\BaseRepository;

class MenuRepository extends BaseRepository
{
    public function model()
    {
        return Menu::class;
    }
}