<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 5/7/2018
 * Time: 11:30 AM
 */

namespace MultipleChoices\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Course\Repositories\CourseCurriculumItemsRepository;
use MultipleChoices\Repositories\AnswerRepository;
use MultipleChoices\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use MultipleChoices\Models\Answer;

class QuestionController extends BaseController
{
    protected $repository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->repository = $questionRepository;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed|string
     */
    public function addQuestion(Request $request)
    {
        $data = $request->all();
        $question = $this->repository->addQuestion($data);
        return $question;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function updateQuestion(Request $request)
    {
        $data = $request->all();
        $question = $this->repository->updateQuestion($data);
        return $question;
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function deleteQuestion(Request $request)
    {
        $id = $request->get('id');
        $this->repository->delete($id);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function onSortEnd(Request $request)
    {
        $data = $request->all();
        $items = $this->repository->onSortEnd($data['items']);
        return $items;
    }

    public function createTestQuestion(Request $request, AnswerRepository $answerRepository)
    {
        $data = $request->all();
        $question = $this->repository->create([
            'content' => $data['question'],
            'curriculum_item' => $data['curriculum_item'],
            'knowledge_area' => $data['knowledgeArea'],
            'reason' => $data['explain'],
            'type' => 'multi',
            'owner' => $data['owner'],
        ]);

        foreach ($data['answers'] as $ans) {
            if ($ans['content'] != null) {
                $answerRepository->create([
                    'content' => $ans['content'],
                    'check' => $ans['check'],
                    'question' => $question->id
                ]);
            }
        }

        return $question;
    }

    public function updateTestQuestion(Request $request)
    {
        $data = $request->all();

        try {
            $answers = $data['answers'];
            $question = $data['question'];
            $curriculum_item = $data['curriculum_item'];
            $explain = $data['explain'];
            $id = $data['id'];
            $knowledgeArea = $data['knowledgeArea'];

            $newQuestion = $this->repository->update([
                'content' => $question,
                'knowledge_area' => $knowledgeArea,
                'reason' => $explain
            ], $id); //Update questin first;

            //Delete all old answer
            //Add new question

            Answer::where('question', $id)->delete();

            foreach ($answers as $k => $a) {
                if ($a['content'] != null) {
                    try {
                        $ans = new Answer();
                        $ans->content = $a['content'];
                        $ans->reason = $a['reason'];
                        $ans->question = $id;
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

    public function getContent(
        Request $request,
        CourseCurriculumItemsRepository $courseCurriculumItemsRepository,
        QuestionRepository $questionRepository
    )
    {
        try {
            $data = $request->get('id');
            $lecture = $courseCurriculumItemsRepository->find($data);
            $question = $questionRepository->findWhere(['curriculum_item' => $lecture->id])->count();
            $lecture = $lecture->toArray();
            $lecture['total_question'] = $question;
            return $lecture;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getQuestionLength(Request $request)
    {
        $lectureid = $request->get('lectureid');
        $length = $this->repository->findWhere([
            'curriculum_item' => $lectureid
        ])->count();

        return $length;
    }
}