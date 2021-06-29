<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 5/7/2018
 * Time: 11:23 AM
 */

namespace MultipleChoices\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
	protected $table = 'answers';
	protected $guarded = [];
	protected $fillable = [
		'content', 'reason', 'question', 'created_at', 'answer'
	];
	
	public function setQuestionAttribute($id)
	{
		$this->attributes['question'] = intval($id);
	}
	
	public function getQuestion()
	{
		$this->belongsTo(Question::class, 'question');
	}
}