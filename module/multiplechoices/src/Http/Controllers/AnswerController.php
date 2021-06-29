<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 5/7/2018
 * Time: 11:30 AM
 */

namespace MultipleChoices\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Illuminate\Http\Request;
use MultipleChoices\Repositories\AnswerRepository;

class AnswerController extends BaseController
{
	protected $repository;
	
	public function __construct(AnswerRepository $answerRepository)
	{
		$this->repository = $answerRepository;
	}
	
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return mixed|string
	 */
	public function addAnswers(Request $request)
	{
		try {
			$data = $request->all();
			$answers = $this->repository->addAnswers($data);
			return $answers;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
	
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return mixed|string
	 */
	public function getAnswers(Request $request)
	{
		try {
			$data = $request->get('questionId');
			$answers = $this->repository->findWhere(
				['question' => $data],
				['id', 'content', 'reason', 'answer']
			);
			return $answers;
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}
}