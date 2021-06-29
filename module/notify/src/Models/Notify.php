<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/10/2018
 * Time: 11:06 AM
 */

namespace Notify\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Users\Models\Users;

class Notify extends Model
{
	protected $table = 'notify';
	protected $guarded = [];
	protected $fillable = [
		'apply_with', 'start_time', 'end_time', 'content','name','status','created_at', 'updated_at', 'published_at'
	];
	
	/**
	 * Convert string timestrap to Carbon obj
	 * @param $value
	 */
	public function setPublishedAtAttribute($value)
	{
		$published_at = strtotime(str_replace('/', '-', $value));
		$published_at = Carbon::createFromTimestamp($published_at);
		$this->attributes['published_at'] = $published_at;
	}
	

}