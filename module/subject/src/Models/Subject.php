<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 5:36 PM
 */

namespace Subject\Models;

use ClassLevel\Models\ClassLevel;
use Illuminate\Database\Eloquent\Model;
use Users\Models\Users;
use Carbon\Carbon;

class Subject extends Model
{
	protected $table = 'subject';
	protected $guarded = [];
	protected $fillable = [
		'name', 'slug', 'icon', 'seo_title', 'seo_keywords', 'seo_description', 'author', 'editor', 'published_at',
		'created_at', 'updated_at'
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
	
	/**
	 * Relation n - n
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function classLevel()
	{
		return $this->belongsToMany(ClassLevel::class, 'class_subject', 'subject_id', 'class_id');
	}
}