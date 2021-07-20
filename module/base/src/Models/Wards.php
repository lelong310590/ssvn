<?php
/**
 * Wards.php
 * Created by: trainheartnet
 * Created at: 14/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Base\Models;

use Cart\Models\UserSubject;
use ClassLevel\Models\ClassLevel;
use Course\Models\Certificate;
use Illuminate\Database\Eloquent\Model;
use Users\Models\Users;

class Wards extends Model
{
    protected $table = 'wards';

    public $timestamps = false;

    protected $fillable = [
          'ward_id', 'ward_name', 'district_id'
    ];

    public function getCompany()
    {
        return $this->hasMany(ClassLevel::class, 'ward', 'id');
    }

    public function getEnjoynedEmployerInCompany()
    {
        return $this->hasManyThrough(
            UserSubject::class,
            ClassLevel::class,
            'ward',
            'company',
            'id'
        );
    }

    public function getCertificate()
    {
        return $this->hasMany(Certificate::class, 'ward', 'id');
    }

    public function getEnjoynedCompany()
    {
        return $this->hasManyThrough(
            UserSubject::class,
            ClassLevel::class,
            'ward',
            'company',
            'id'
        );
    }

    public function getCompanyCertificate()
    {
        return $this->hasMany(Certificate::class, 'ward', 'id');
    }

    public function getAreanameAttribute()
    {
        return $this->attributes['ward_name'];
    }
}