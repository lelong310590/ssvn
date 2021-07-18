<?php
/**
 * Wards.php
 * Created by: trainheartnet
 * Created at: 14/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Base\Models;

use ClassLevel\Models\ClassLevel;
use Course\Models\Certificate;
use Illuminate\Database\Eloquent\Model;

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

    public function getCertificate()
    {
        return $this->hasManyThrough(
            Certificate::class,
            ClassLevel::class,
            'ward',
            'company_id',
            'id'
        );
    }

    public function getAreanameAttribute()
    {
        return $this->attributes['ward_name'];
    }
}