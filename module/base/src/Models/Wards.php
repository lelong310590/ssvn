<?php
/**
 * Wards.php
 * Created by: trainheartnet
 * Created at: 14/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Base\Models;

use Illuminate\Database\Eloquent\Model;

class Wards extends Model
{
    protected $table = 'wards';

    public $timestamps = false;

    protected $fillable = [
          'ward_id', 'ward_name', 'district_id'
    ];
}