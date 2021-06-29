<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/10/2018
 * Time: 11:06 AM
 */

namespace Qa\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Users\Models\Users;

class Answer extends Model
{
	protected $table = 'answer';
	protected $guarded = [];
	protected $fillable = [
		'question', 'content', 'report', 'image', 'usefull', 'created_at', 'updated_at', 'published_at','author'
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
    public function getQuestion()
    {
        return $this->belongsTo(Question::class, 'question');
    }
}