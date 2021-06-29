<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 6/18/2018
 * Time: 10:56 AM
 */

namespace Course\Repositories;

use Course\Models\TestResult;
use Prettus\Repository\Eloquent\BaseRepository;

class TestResultRepository extends BaseRepository
{
    public function model()
    {
        // TODO: Implement model() method.
        return TestResult::class;
    }
}