<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/12/2018
 * Time: 11:42 AM
 */

namespace Messages\Repositories;

use Messages\Models\MessageDetail;
use Prettus\Repository\Eloquent\BaseRepository;

class MessageDetailRepository extends BaseRepository
{
    public function model()
    {
        // TODO: Implement model() method.
        return MessageDetail::class;
    }
}