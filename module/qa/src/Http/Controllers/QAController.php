<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 5/24/2018
 * Time: 3:03 PM
 */

namespace Qa\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Illuminate\Http\Request;
use Qa\Repositories\QuestionRepository;
use Qa\Repositories\ReplyRepository;

class QAController extends BaseController
{
    protected $question;
    protected $answer;

    public function __construct(QuestionRepository $questionRepository, ReplyRepository $replyRepository)
    {
        $this->question = $questionRepository;
        $this->answer = $replyRepository;
    }

    public function listQuestion(Request $request)
    {
        $courseid = $request->get('courseid');
        $lectureid = $request->get('lectureid');
        $userid = $request->get('userid');

        try {
            $questions = $this->question->with('owner')->orderBy('created_at', 'desc')
            ->findWhere([
                'course' => $courseid,
                'lecture' => $lectureid,
                'author' => $userid,
            ])->all();

            foreach ($questions as $q) {
                $q['onEdit'] = false;
            }

            return $questions;
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * @param Request $request
     * @return mixed|string
     */
    public function postQuestion(Request $request)
    {
        $content = $request->get('content');
        $course = $request->get('courseid');
        $lecture = $request->get('lectureid');
        $title = $request->get('title');
        $author = $request->get('userid');

        try {
            $question = $this->question->create([
                'content' => $content,
                'course' => $course,
                'lecture' => $lecture,
                'title' => $title,
                'author' => $author
            ]);

            $questionReturn = $this->question->with('owner')->orderBy('created_at', 'desc')->find($question->id);
            $questionReturn['onEdit'] = false;

            return $questionReturn;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param Request $request
     * @return mixed|string
     */
    public function postAnswer(Request $request)
    {
        $content = $request->get('answerContent');
        $author = $request->get('author');
        $question = $request->get('question');

        try {
            $answer = $this->answer->create([
                'content' => $content,
                'author' => $author,
                'question' => $question
            ]);

            $returnAnswer = $this->answer->with('owner')->orderBy('created_at', 'desc')
                ->find($answer->id);

            $returnAnswer['onEdit'] = false;

            return $returnAnswer;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param Request $request
     * @return mixed|string
     */
    public function listAnswer(Request $request)
    {
        $author = $request->get('author');
        $question = $request->get('question');

        try {
            $answers = $this->answer->with('owner')->findWhere([
                'author' => $author,
                'question' => $question
            ]);

            foreach ($answers as $a) {
                $a['onEdit'] = false;
            }

            return $answers;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param Request $request
     * @return mixed|string
     */
    public function editQuestion(Request $request)
    {
        $content = $request->get('content');
        $id = $request->get('id');
        $title = $request->get('title');

        try {
            $question = $this->question->update([
                'content' => $content,
                'title' => $title
            ], $id);

            $returnQuestion = $this->question->with('owner')->find($question->id);
            $returnQuestion['onEdit'] = false;
            return $returnQuestion;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function editAnswer(Request $request)
    {
        $content = $request->get('content');
        $id = $request->get('id');

        try {
            $answer = $this->answer->update([
                'content' => $content
            ], $id);

            $returnAnser = $this->answer->with('owner')->find($answer->id);
            $returnAnser['onEdit'] = false;
            return $returnAnser;
        } catch(\Exception $e) {
            return $e->getMessages();
        }
    }

    public function deleteQuestion(Request $request)
    {
        $id = $request->get('id');
        $type = $request->get('qatype');

        if ($type == 'question') {
            $answer = $this->answer->findWhere(['question' => $id]);
            foreach ($answer as $a) {
                $this->answer->delete($a->id);
            }
            $this->question->delete($id);
        }

        if ($type == 'answer') {
            $this->answer->delete($id);
        }
    }
}