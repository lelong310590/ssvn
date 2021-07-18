<?php
/**
 * Districts.php
 * Created by: trainheartnet
 * Created at: 14/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Base\Models;

use ClassLevel\Models\ClassLevel;
use Course\Models\Certificate;
use Illuminate\Database\Eloquent\Model;

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

    public function getAreanameAttribute()
    {
        return $this->attributes['district_name'];
    }

    public function getCertificate()
    {
        return $this->hasManyThrough(
            Certificate::class,
            ClassLevel::class,
            'district',
            'company_id',
            'id'
        );
    }
}