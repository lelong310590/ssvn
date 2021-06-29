<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 5/7/2018
 * Time: 11:29 AM
 */

namespace MultipleChoices\Repositories;

use MultipleChoices\Models\Answer;
use Prettus\Repository\Eloquent\BaseRepository;

class AnswerRepository extends BaseRepository
{
	public function model()
	{
		// TODO: Implement model() method.
		return Answer::class;
	}
	
	/**
	 * @param $data
	 *
	 * @return mixed|string
	 */
	public function addAnswers($data)
	{
		try {
			$answers = $data['answers'];
            $questionId = $data['questionId'];
            $trueAnswerPosition = $data['answer'];

            $trueAnswer = 'N';

			foreach ($answers as $key => $a) {
				if ($a['content'] != null) {

				    if ($trueAnswerPosition == $key) {
                        $trueAnswer = 'Y';
                    } else {
                        $trueAnswer = 'N';
                    }

					$this->create([
						'content' => $a['content'],
						'reason' => $a['reason'],
						'question' => $questionId,
                        'answer' => $trueAnswer
					]);
				}
			}
			
			//Return current added answer
			$addAnswers = $this->findWhere(['question' => $questionId]);
			return $addAnswers;
			
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
}