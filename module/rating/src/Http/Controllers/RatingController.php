<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 6/30/2018
 * Time: 3:12 PM
 */

namespace Rating\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Illuminate\Http\Request;
use Rating\Repositories\RatingRepository;
use Illuminate\Support\Facades\DB;

class RatingController extends BaseController
{
    protected $repository;

    public function __construct(RatingRepository $ratingRepository)
    {
        $this->repository = $ratingRepository;
    }

    /**
     * @param Request $request
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function postRating(Request $request)
    {
        $courseid = $request->get('courseid');
        $initialRating = $request->get('initialRating');
        $ratingComment = $request->get('ratingComment');
        $userId = $request->get('userId');

        $this->repository->create([
            'rating_number' => $initialRating,
            'content' => $ratingComment,
            'course' => $courseid,
            'author' => $userId
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function checkIsRated(Request $request)
    {
        $author = $request->get('author');
        $course = $request->get('course');

        $isChecked = DB::table('rating')->where([
            ['author', $author],
            ['course', $course],
        ])->exists();

        return ['rated' => $isChecked];
    }
}