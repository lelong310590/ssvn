<?php
/**
 * Districts.php
 * Created by: trainheartnet
 * Created at: 14/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Base\Models;

use Cart\Models\Order;
use Cart\Models\UserSubject;
use ClassLevel\Models\ClassLevel;
use Course\Models\Certificate;
use Illuminate\Database\Eloquent\Model;
use Users\Models\Users;

class Districts extends Model
{
    protected $table = 'districts';

    public $timestamps = false;

    protected $fillable = [
        'district_id' , 'district_value', 'district_name', 'province_id'
    ];

    public function getWards()
    {
        return $this->hasMany(Wards::class, 'district_id', 'id');
    }

    public function getCompany()
    {
        return $this->hasMany(ClassLevel::class, 'district', 'id');
    }

    public function getEnjoynedEmployerInCompany()
    {
        return $this->hasManyThrough(
            UserSubject::class,
            ClassLevel::class,
            'district',
            'company',
            'id'
        );
    }

    public function getEnjoynedCompany()
    {
        return $this->hasManyThrough(
            UserSubject::class,
            ClassLevel::class,
            'district',
            'company',
            'id'
        );
    }

    public function getCompanyCertificate()
    {
        return $this->hasMany(Certificate::class, 'district', 'id');
    }

    public function getCertificate()
    {
        return $this->hasMany(Certificate::class, 'district', 'id');
    }

    public function getAreanameAttribute()
    {
        return $this->attributes['district_name'];
    }
}