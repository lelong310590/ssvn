<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/10/2018
 * Time: 2:46 PM
 */

namespace Tag\Models;

use Course\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Users\Models\Users;

class Tag extends Model
{
	protected $table = 'tag';
	protected $guarded = [];
	protected $fillable = [
		'name', 'slug', 'created_at', 'deleted_at', 'author'
	];
	
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function owner()
	{
		return $this->belongsTo(Users::class, 'author');
	}
	
	/**
	 * Relationship n - n with course
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function getCourse()
	{
		return $this->belongsToMany(Course::class, 'course_tag', 'tag_id', 'course_id')->withTimestamps();
	}
}