<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 5/7/2018
 * Time: 11:19 AM
 */

namespace MultipleChoices\Models;

use Illuminate\Database\Eloquent\Model;
use Users\Models\Users;

class Question extends Model
{
	protected $table = 'questions';
	protected $guarded = [];
	protected $fillable = [
		'content', 'curriculum_item', 'related_lecture', 'answer', 'index', 'created_at', 'owner', 'type',
        'knowledge_area', 'reason'
	];
	
	/**
	 * @param $val
	 */
	public function setRelatedLectureAttribute($val)
	{
		$this->attributes['related_lecture'] = ($val == 0) ? null : intval($val);
	}
	
	/**
	 * @param $val
	 */
	public function setAnswerAttribute($val)
	{
		$this->attributes['answer'] = json_encode($val);
	}
	
	/**
	 * @param $val
	 */
	public function setCurriculumItemAttribute($val)
	{
		$this->attributes['curriculum_item'] = ($val == 0) ? null : intval($val);
	}
	
	/**
	 * Relation ship 1 - 1 with users
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function getOwner()
	{
		return $this->belongsTo(Users::class, 'owner');
	}
	
	/**
	 * Relation ship 1 - n between question & answer
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function getAnswer()
	{
		return $this->hasMany(Answer::class, 'question', 'id');
	}
}