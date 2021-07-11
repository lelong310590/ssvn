<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 6/14/2018
 * Time: 1:57 PM
 */

namespace Course\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Course\Repositories\CourseCurriculumItemsRepository;
use Course\Repositories\TestResultRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use MultipleChoices\Repositories\AnswerRepository;
use MultipleChoices\Repositories\QuestionRepository;
use Users\Repositories\UsersRepository;

class TestResultController extends BaseController
{
    public function submitTest(Request $request, UsersRepository $usersRepository)
    {
        try {
            $answers = $request->get('answers');
            $userId = $request->get('userId');
            $lectureId = $request->get('lectureId');
            $skip = $request->get('skip');
            $correct = $request->get('correct');
            $wrong = $request->get('wrong');
            $score = $request->get('score');
            $version = $request->get('version');
            $test_time = $request->get('test_time');
            $time = $request->get('time');
            $courseid = intval($request->get('courseid'));
            $isexam = intval($request->get('isexam'));

            $totalQuestion = $wrong + $skip + $correct;
            $percent_correct = round($correct / $totalQuestion * 100);

            $testResult = ($percent_correct >= $score) ? 'pass' : 'failed';

            $result = DB::table('test_result')->insertGetId([
                'owner' => $userId,
                'lecture_id' => $lectureId,
                'skip' => $skip,
                'correct' => $correct,
                'wrong' => $wrong,
                'detail' => json_encode($answers),
                'score' => $score,
                'version' => $version,
                'percent_correct' => $percent_correct,
                'result' => $testResult,
                'question' => null,
                'test_time' => $test_time,
                'time' => $time,
                'created_at' => Carbon::now()
            ]);

            if ($isexam == 1) {
                $usersRepository->sync($userId, 'getExam', [$courseid]);
            }

            return [
                'courseid' => $courseid,
                'isexam' => $isexam
            ];

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function checkAnswer(
        Request $request,
        QuestionRepository $questionRepository,
        AnswerRepository $answerRepository
    )
    {
        try {
            $correct = false;
            $wrong = false;
            $defaultAnwsers = [];

            $answers = $request->get('answers');
            $questionid = $request->get('question');
            $question = $questionRepository->find($questionid);

            if ($question->type == 'multi') {
                $defaultAnwsers = $answerRepository->scopeQuery(function ($q) use ($questionid) {
                    return $q->where('answer', 'Y')->where('question', $questionid)->pluck('id');
                })->get();

                $tempNum = count($defaultAnwsers);
                // Kiem tra dap an
                $start = 0;

                if (count($answers) >= $tempNum) {
                    foreach ($answers as $a) {
                        if (in_array($a, $defaultAnwsers)) {
                            $start += 1;
                        }
                    }
                }

                if ($start >= $tempNum) {
                    $correct = true;
                } else {
                    $wrong = true;
                }

            } else {
                $correctAnswer = $answerRepository->findWhere([
                    'answer' => 'Y',
                    'question' => $questionid
                ], ['id'])->first();

                if ($answers == $correctAnswer->id) {
                    $correct = true;
                } else {
                    $wrong = true;
                }
            }

            return [
                'correct' => $correct,
                'wrong' => $wrong,
                'id' => $questionid
            ];


        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param Request $request
     * @param TestResultRepository $testResultRepository
     * @return array
     */
    public function getResult(Request $request, TestResultRepository $testResultRepository)
    {
        try {
            $userid = $request->get('userid');
            $lectureid = $request->get('lecture');
            $result = $testResultRepository->orderBy('created_at', 'desc')
                ->findWhere([
                    'owner' => $userid,
                    'lecture_id' => $lectureid
                ])->groupBy('version')->toArray();

            $group = array();

            foreach ( $result as $value ) {
                $group[] = $value;
            }

            return $group;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function resultReview(
        Request $request, TestResultRepository $testResultRepository
    )
    {
        $id = $request->get('reviewID');
        $result = $testResultRepository->with(['lecture' => function($q) {
            return $q->select('id')->with(['getAllQuestion' => function($query) {
                return $query->select('id', 'curriculum_item', 'content', 'reason')->with(['getAnswer' => function($answer) {
                    return $answer->select('id', 'question', 'content', 'answer');
                }]);
            }]);
        }])->find($id, [
            'id', 'owner', 'lecture_id', 'skip','correct', 'wrong',
            'version', 'time', 'score', 'detail'
        ]);


        return $result;
    }

    public function getLeaderboards(Request $request, TestResultRepository $testResultRepository)
    {
        $lectureId = $request->get('lecture_id');
        $results = $testResultRepository->makeModel()
            ->select('id', 'score', 'test_time', 'time', 'percent_correct', 'created_at', 'owner')
            ->where(['lecture_id' => $lectureId])
            ->orderBy('percent_correct', 'desc')
            ->get()
            ->load('owner')
            ->unique('owner')
        ;

        return $results;
    }
}