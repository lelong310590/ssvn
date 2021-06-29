<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 6/20/2018
 * Time: 10:52 AM
 */

namespace Course\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Course\Repositories\CourseCurriculumItemsRepository;
use Course\Repositories\CourseRepository;
use Course\Repositories\CurriculumProgressRepository;
use Illuminate\Http\Request;

class CurriculumProcessController extends BaseController
{
    protected $repository;

    public function __construct(CurriculumProgressRepository $curriculumProgressRepository)
    {
        $this->repository = $curriculumProgressRepository;
    }

    public function getProcess(Request $request)
    {
        return $request->all();
    }

    public function changeProcess(
        Request $request,
        CourseCurriculumItemsRepository $courseCurriculumItemsRepository
    )
    {
        try {
            $courseid = $request->get('section');
            $curriculumid = $request->get('courseid');
            $userid = $request->get('userid');
            $status = $request->get('status') ? 3 : 1;

            $courseProcess = $this->repository->findWhere([
                'course_id' => $courseid,
                'curriculum_id' => $curriculumid,
                'student' => $userid
            ])->first();

            if (!empty($courseProcess)) {
                $this->repository->update([
                    'status' => $status
                ], $courseProcess->id);
            }

            $courseItem = $courseCurriculumItemsRepository->with('getProcess')->find($curriculumid);

            return $courseItem;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}