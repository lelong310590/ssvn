<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/6/2018
 * Time: 11:12 PM
 */

namespace Level\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Users\Models\Users;

class Level extends Model
{
	protected $table = 'level';
	protected $guarded = [];
	protected $fillable = [
		'name', 'slug', 'thumbnail', 'seo_title', 'seo_keywords', 'seo_description', 'author', 'editor', 'status',
		'featured', 'published_at', 'created_at', 'updated_at'
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
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function owner()
	{
		return $this->belongsTo(Users::class, 'author');
	}
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function edit()
	{
		return $this->belongsTo(Users::class, 'editor');
	}
}