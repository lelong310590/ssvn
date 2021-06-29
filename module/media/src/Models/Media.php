<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/28/2018
 * Time: 9:50 AM
 */

namespace Media\Models;

use Course\Models\CourseCurriculumItems;
use Illuminate\Database\Eloquent\Model;
use Users\Models\Users;

class Media extends Model
{
	protected $table = 'media';
	protected $guarded = [];
	protected $fillable = [
		'name', 'url', 'type', 'owner', 'curriculum_item', 'duration', 'reject_reason', 'status',
		'created_at', 'thumbnail'
	];
	
	
	public function owner()
	{
		return $this->belongsTo(Users::class, 'owner');
	}
	
	public function curriculum()
	{
		return $this->belongsTo(CourseCurriculumItems::class, 'curriculum_item');
	}

	public function getUrlAttribute($value)
    {
//        if($this->type === 'video/mp4') {
//            return ends_with($value, '/index.m3u8') ? $value : $value . '/index.m3u8';
//        }

        return $value;
    }
}