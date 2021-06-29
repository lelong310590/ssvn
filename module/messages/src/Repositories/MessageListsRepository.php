<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/12/2018
 * Time: 11:42 AM
 */

namespace Messages\Repositories;

use Messages\Models\MessageLists;
use Prettus\Repository\Eloquent\BaseRepository;

class MessageListsRepository extends BaseRepository
{
    public function model()
    {
        // TODO: Implement model() method.
        return MessageLists::class;
    }
}