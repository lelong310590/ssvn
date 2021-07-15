<?php
/**
 * Provinces.php
 * Created by: trainheartnet
 * Created at: 14/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Base\Models;

use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    protected $table = 'provinces';

    public $timestamps = false;

    protected $fillable = [
        'province_id', 'province_code', 'province_name'
    ];

    public function getDistrict()
    {
        return $this->hasMany(Districts::class, 'province_id', 'id');
    }
}