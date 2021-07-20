<?php
/**
 * UserSubjectRepository.php
 * Created by: trainheartnet
 * Created at: 20/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Cart\Repositories;

use Cart\Models\UserSubject;
use Prettus\Repository\Eloquent\BaseRepository;

class UserSubjectRepository extends BaseRepository
{
    public function model()
    {
        // TODO: Implement model() method.
        return UserSubject::class;
    }
}