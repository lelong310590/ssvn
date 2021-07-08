<?php
/**
 * CertificateRepository.php
 * Created by: trainheartnet
 * Created at: 08/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Course\Repositories;

use Course\Models\Certificate;
use Prettus\Repository\Eloquent\BaseRepository;

class CertificateRepository extends BaseRepository
{
    public function model()
    {
        // TODO: Implement model() method.
        return Certificate::class;
    }
}