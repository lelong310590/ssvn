<?php

namespace Course\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Course\Http\Requests\CreateLectureReportRequest;
use Course\Models\CourseCurriculumItemReport;

/**
 * Class LectureReportController
 * @package Course\Http\Controllers\Fronten
 */
class LectureReportController extends Controller
{
    /**
     * @param CreateLectureReportRequest $request
     * @return CourseCurriculumItemReport|string
     */
    public function store(CreateLectureReportRequest $request)
    {
        $report = new CourseCurriculumItemReport($request->input([
            'user_id',
            'content',
            'course_id',
            'lecture_id',
            'question_id',
        ]));

        try {
            $report->save();
            return $report;
        } catch(\Exception $exception)
        {
            return $exception->getMessage();
        }
    }
}