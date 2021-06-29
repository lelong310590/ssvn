<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 5/7/2018
 * Time: 11:23 AM
 */

namespace MultipleChoices\Repositories;

use MultipleChoices\Models\Answer;
use MultipleChoices\Models\Question;
use Prettus\Repository\Eloquent\BaseRepository;

class QuestionRepository extends BaseRepository
{
	public function model()
	{
		return Question::class;
	}
	
	/**
	 * @param $cId
	 *
	 * @return mixed
	 */
	protected function getAllQuestionInCurriculum($cId)
	{
		$questions = $this->orderBy('updated_at', 'asc')
		                  ->findWhere([
								'curriculum_item' => $cId
		                  ])->count();
		
		return $questions;
	}
	
	/**
	 * @param $data
	 *
	 * @return mixed|string
	 */
	public function addQuestion($data)
	{
		try {
			$curriculumItem = $data['curriculum_item'];
			$questionQty = $this->getAllQuestionInCurriculum($curriculumItem);
			$data['index'] = $questionQty;
			$question = $this->create($data);
			return $question;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
		
	}
	
	/**
	 * @param $data
	 *
	 * @return mixed
	 */
	public function updateQuestion($data)
	{
		try {
			$answers = $data['answers'];
			$content = $data['content'];
			$question = $data['question'];
			$related_lecture = $data['related_lecture'];
			$reason = $data['reason'];
			
			$newQuestion = $this->update([
				'content' => $content,
				'related_lecture' => $related_lecture,
                'reason' => $reason
			], $question['id']); //Update questin first;
			
			//Delete all old answer
			//Add new question
			
			Answer::where('question', $question['id'])->delete();
			
			foreach ($answers as $k => $a) {
				if ($a['content'] != null) {
					try {
						$ans = new Answer();
						$ans->content = $a['content'];
						$ans->reason = $a['reason'];
						$ans->question = $question['id'];
						$ans->answer = $a['answer'];
						$ans->save();
					} catch (\Exception $e) {
						return $e->getMessage();
					}
				}
			}
			return $newQuestion;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	
	/**
	 * @param $data
	 */
	public function onSortEnd($data)
	{
		foreach ($data as $k => $value) {
			$this->update(['index' => $k], $value['id']);
		}
	}
}