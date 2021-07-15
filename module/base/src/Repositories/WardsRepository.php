<?php
/**
 * WardsRepository.php
 * Created by: trainheartnet
 * Created at: 14/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Base\Repositories;

use Base\Models\Wards;
use Prettus\Repository\Eloquent\BaseRepository;

class WardsRepository extends BaseRepository
{
    public function model()
    {
        // TODO: Implement model() method.
        return Wards::class;
    }
}