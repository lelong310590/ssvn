<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/12/2018
 * Time: 3:41 PM
 */

namespace Course\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Carbon\Carbon;
use Cart\Repositories\OrderDetailsRepository;
use Course\Models\CourseCurriculumItems;
use Course\Repositories\CourseCurriculumItemsRepository;
use Course\Repositories\CourseRepository;
use Course\Repositories\CurriculumProgressRepository;
use Course\Repositories\TestResultRepository;
use Illuminate\Http\Request;
use Media\Repositories\MediaRepository;
use MultipleChoices\Repositories\QuestionRepository;
use Qa\Repositories\QuestionRepository as Question;
use File;
use Cache;

class CourseCurriculumItemsController extends BaseController
{
    protected $repository;
    protected $path;
    protected $baseUrl;

    public function __construct(CourseCurriculumItemsRepository $courseSectionRepository)
    {
        $this->repository = $courseSectionRepository;
        $this->path = public_path() . '/';
        $this->baseUrl = env('APP_URL');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function getAllItems(Request $request)
    {
        $id = $request->get('cId');
        $section = $this->repository->getAllSection($id);
        return $section;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array|mixed
     */
    public function addItem(Request $request)
    {
        $data = $request->except('userid');
        $userid = $request->get('userid');
        $newSection = $this->repository->addSection($data, $userid);
        return $newSection;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function deleteItem(
        Request $request, MediaRepository $mediaRepository, QuestionRepository $questionRepository,
        CurriculumProgressRepository $curriculumProgressRepository, Question $question,
        TestResultRepository $testResultRepository
    )
    {
        try {
            $id = $request->get('id');

            $curriculumProgressRepository->deleteWhere(['curriculum_id' => $id]);

            $media = $mediaRepository->scopeQuery(function ($e) use ($id) {
                return $e->where('curriculum_item', $id);
            })->all();

            foreach ($media as $m) {
                $mediaRepository->update([
                    'curriculum_item' => null
                ], $m->id);
            }

            $questionRepository->deleteWhere(['curriculum_item' => $id]);

            $questionRepository->scopeQuery(function ($e) use ($id) {
                $e->where('related_lecture', $id)->update(['related_lecture' => null]);
            });

            $testResultRepository->deleteWhere(['lecture_id' => $id]);

            $question->deleteWhere(['lecture' => $id]);

            $this->repository->delete($id);

            return [
                'code_status' => true
            ];
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function updateItem(Request $request)
    {
        $data = $request->all();
        $newItem = $this->repository->updateItem($data);
        $newItem['onEdit'] = false;
        return $newItem;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function onSortEnd(Request $request)
    {
        $data = $request->all();
        $result = $this->repository->onSortEnd($data['items'], $data['oldIndex'], $data['newIndex']);
        return $result;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function updateDescription(Request $request)
    {
        $data = $request->all();
        $item = $this->repository->updateDescription($data);
        return $item;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function updateStatus(Request $request)
    {
        $data = $request->all();
        $item = $this->repository->updateStatus($data);
        return $item;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function updatePreview(Request $request)
    {
        $data = $request->all();
        $item = $this->repository->updatePreview($data);
        return $item;
    }

    /**
     * @param $courseId
     *
     * @return mixed
     */
    public function getRelatedItems(Request $request)
    {
        $courseId = $request->get('course_id');
        $item = $this->repository->orderBy('created_at', 'desc')
            ->findWhere([
                'course_id' => $courseId,
                'status' => 'active',
                'type' => 'lecture'
            ], ['name', 'id'])->all();
        return $item;
    }

    public function getAllSection(Request $request)
    {
        $id = $request->get('cId');

        $section = $this->repository->orderBy('index', 'asc')
            ->findWhere([
                'type' => 'section',
                'course_id' => $id,
                'status' => 'active'
            ]);
        $lecture = $this->repository->orderBy('index', 'asc')
            ->findWhere([
                ['type', '!=', 'section'],
                'course_id' => $id,
                'status' => 'active'
            ]);

        return [
            'section' => $section,
            'lecture' => $lecture,
        ];

        // Bắt đầu API mới
        $lectures = $this->repository->orderBy('index', 'asc')->with('getMedia')
            ->findWhere([
                'course_id' => $id,
                'status' => 'active'
            ]);
        $return = [];
        foreach ($lectures as $lecture) {
            array_push($return, $lecture);
            if ($lecture->getMedia->where('type', '!=', 'video/mp4')->count() > 0) {
                foreach ($lecture->getMedia->where('type', '!=', 'video/mp4') as $media) {
                    array_push($return, $media);
                }
            }
        }
        return [
            'lecture' => $return,
        ];
    }

    public function getLectureInSection(
        Request $request,
        CourseRepository $courseRepository
    )
    {
        try {
            $id = $request->get('section');
            $course_id = $request->get('courseid');

            $course = Cache::remember('courseapi-' . $course_id, 60 * 60 * 24, function () use ($courseRepository, $course_id) {
                return $courseRepository->find($course_id);
            });

            $section = $this->repository->find($id);

            $userid = $request->get('userid');

            $nextSection = $this->repository->findWhere([
                'course_id' => $section->course_id,
                'type' => 'section',
                ['index', '>', $section->index],
                'status' => 'active'
            ])->first();

            $lecture = [];

            if (!empty($nextSection)) {
                $lecture = $this->repository->orderBy('index', 'asc')
                    ->with('getMedia')
                    ->with(['getProcess' => function ($q) use ($userid) {
                        return $q->where('student', $userid)->where('status', 3);
                    }])
                    ->findWhere([
                        'course_id' => $section->course_id,
                        ['type', '!=', 'section'],
                        ['index', '>', $section->index],
                        ['index', '<', $nextSection->index],
                        'status' => 'active'
                    ])->all();
            } else {
                $lecture = $this->repository->orderBy('index', 'asc')
                    ->with('getMedia')
                    ->with(['getProcess' => function ($q) use ($userid) {
                        return $q->where('student', $userid)->where('status', 3);
                    }])
                    ->findWhere([
                        'course_id' => $section->course_id,
                        ['type', '!=', 'section'],
                        ['index', '>', $section->index],
                        'status' => 'active'
                    ])->all();
            }

            return [
                'lecture' => $lecture,
                'course' => $course
            ];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param Request $request
     * @param CourseCurriculumItemsRepository $courseCurriculumItemsRepository
     * @return array
     */
    public function getLectureInfo(
        Request $request,
        CourseCurriculumItemsRepository $courseCurriculumItemsRepository,
        MediaRepository $mediaRepository
    )
    {
        $data = $request->get('id');
        $lecture = $courseCurriculumItemsRepository->find($data);
        if ($lecture->parent_section != 0) {
            $parentSection = $courseCurriculumItemsRepository->find($lecture->parent_section);
            $listLecture = $courseCurriculumItemsRepository->orderBy('index', 'asc')
                ->findWhere([
                    'parent_section' => $parentSection->id
                ]);
        } else {
            $parentSection = null;
            $listLecture = null;
        }
        $resources = $mediaRepository->findWhere([
            'curriculum_item' => $data,
            ['type', '!=', 'video/mp4']
        ])->count();

        return [
            'section' => $parentSection,
            'list_lecture' => $listLecture,
            'resources' => $resources
        ];
    }

    /**
     * @param Request $request
     * @param CourseCurriculumItemsRepository $courseCurriculumItemsRepository
     * @param CourseRepository $courseRepository
     * @return array
     */
    public function getLectureInfoRoute(
        Request $request,
        CourseCurriculumItemsRepository $courseCurriculumItemsRepository,
        CourseRepository $courseRepository,
        QuestionRepository $questionRepository
    )
    {
        try {
            $courseId = $request->get('courseId');
            $lectureId = $request->get('lectureId');
            $lecture = $courseCurriculumItemsRepository->find($lectureId);
            $course = $courseRepository->find($courseId);
            $listLecture = $courseCurriculumItemsRepository->orderBy('index', 'asc')
                ->findWhere([
                    'course_id' => $course->id,
                    ['type', '!=', 'section'],
                    'status' => 'active'
                ]);
            $question = $questionRepository->findWhere(['curriculum_item' => $lecture->id])->count();
            $lecture = $lecture->toArray();
            $lecture['total_question'] = $question;
            return [
                'lecture' => $lecture,
                'list' => $listLecture
            ];

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param Request $request
     * @param MediaRepository $mediaRepository
     * @return mixed
     */
    public function getVideo(Request $request, MediaRepository $mediaRepository)
    {
        try {
            $lecture = $request->get('lecture');
            $media = $mediaRepository->findWhere([
                'curriculum_item' => $lecture,
                'type' => 'video/mp4',
                'status' => 'active'
            ])->first();
            return $media;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param Request $request
     * @param CourseCurriculumItemsRepository $courseCurriculumItemsRepository
     * @return mixed
     */
    public function getSlug(
        Request $request,
        CourseCurriculumItemsRepository $courseCurriculumItemsRepository
    )
    {
        $courseId = $request->get('course');
        $course = $courseCurriculumItemsRepository->with('getCourse')->find($courseId);
        return $course;
    }

    public function getAllQuestions(
        Request $request,
        QuestionRepository $questionRepository,
        TestResultRepository $testResultRepository
    )
    {
        $lecture = $request->get('lectureid');
        $userid = $request->get('userid');
        $questions = $questionRepository
            ->with(['getAnswer' => function($r) {
                $r->inRandomOrder();
            }])
            ->orderBy('index', 'asc')
            ->scopeQuery(function ($q) use ($lecture) {
                return $q->where('curriculum_item', $lecture['id']);
            })->inRandomOrder()->get();

        $result = $testResultRepository->findWhere([
            'owner' => $userid,
            'lecture_id' => $lecture['id']
        ])->all();

        $haveResult = ($result > 0) ? true : false;

        return [
            'questions' => $questions,
            'haveResult' => $haveResult
        ];
    }

    public function searchCurriculum(Request $request)
    {
        $keyword = $request->get('keyword');
        $id = $request->get('cId');

        $lectures = CourseCurriculumItems::where('type', '!=', 'section')
            ->where('course_id', $id)
            ->where('status', 'active')
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
                $query->orWhereHas('getMedia', function ($q) use ($keyword) {
                    $q->where('url', 'like', '%' . $keyword . '%');
                });
            })
            ->orderBy('index', 'asc')->get();

        return $lectures;
    }

    /**
     * @param Request $request
     * @param OrderDetailsRepository $orderDetailsRepository
     * @return string
     */
    public function updateLastCurriculum(Request $request, OrderDetailsRepository $orderDetailsRepository)
    {
        $course_id = $request->get('courseid');
        $last_curriculum_id = $request->get('lecture');
        $author = $request->get('userid');

        try {
            $order = $orderDetailsRepository->findWhere([
                'customer' => $author,
                'course_id' => $course_id
            ])->first();


            if (!empty($order)) {
                $order = $orderDetailsRepository->update([
                    'last_curriculum_id' => $last_curriculum_id
                ], $order->id);
                return $order;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Config\Repository|mixed
     */
    public function uploadImage(Request $request)
    {
        $carbon = new Carbon;
        $currentYear = $carbon->now()->year;
        $currentMonth = $carbon->now()->month;
        $image = $request->file('file');
        $location = $this->path . 'upload/quiz_source/' . $currentYear . '/' . $currentMonth;

        if (!File::exists($location)) {
            File::makeDirectory($location, 0775, true, true);
        }

        $name = $image->getClientOriginalName();
        $fileName = str_slug(pathinfo($name)['filename'], '-');
        $extension = File::extension($name);
        $fullName = $fileName . '.' . $extension;

        if (File::exists($location . '/' . $fullName)) {
            $fullName = $fileName . '-1' . '.' . $extension;
        }

        $image->move($location, $fullName);

        $url = 'https://video.anticovid.com/upload/quiz_source/' . $currentYear . '/' . $currentMonth . '/' . $fullName;

        return $url;
    }
}