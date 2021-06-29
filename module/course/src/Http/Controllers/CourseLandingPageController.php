<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/10/2018
 * Time: 10:26 AM
 */

namespace Course\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Course\Repositories\CourseLdpRepository;
use Course\Repositories\CourseRepository;
use Base\Supports\FlashMessage;
use Subject\Repositories\SubjectRepository;
use ClassLevel\Repositories\ClassLevelRepository;
use Level\Repositories\LevelRepository;
use Course\Http\Requests\CreateCourseLandingPageRequest;
use DebugBar;
use Media\Repositories\MediaRepository;
use Auth;
use Tag\Repositories\TagRepository;

class CourseLandingPageController extends BaseController
{
    protected $repository;

    public function __construct(CourseLdpRepository $courseLdpRepository)
    {
        $this->repository = $courseLdpRepository;
    }

    /**
     * @param \Subject\Repositories\SubjectRepository $subjectRepository
     * @param \ClassLevel\Repositories\ClassLevelRepository $classLevelRepository
     * @param \Level\Repositories\LevelRepository $levelRepository
     * @param \Course\Repositories\CourseRepository $courseRepository
     * @param                                               $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(
        SubjectRepository $subjectRepository,
        ClassLevelRepository $classLevelRepository,
        LevelRepository $levelRepository,
        CourseRepository $courseRepository,
        $id
    )
    {
        $course = $courseRepository->find($id);
        $subjects = $subjectRepository->orderBy('created_at', 'desc')->all();
        $classLevels = $classLevelRepository->orderBy('created_at', 'desc')->all();
        $level = $levelRepository->orderBy('created_at', 'desc')->all();

        $ldp = $this->repository->findWhere([
            'course_id' => $id
        ])->first();
        $tagVal = array();
        if ($ldp) {
            $tags = $ldp->getTag()->get();
            foreach ($tags as $tag) {
                $tagVal[] = $tag->name;
            }
        }
        return view('nqadmin-course::backend.courseldp.index', [
            'subjects' => $subjects,
            'classLevels' => $classLevels,
            'level' => $level,
            'course' => $course,
            'ldp' => $ldp,
            'tags' => $tagVal
        ]);
    }

    /**
     * @param                                                      $id
     * @param \Course\Http\Requests\CreateCourseLandingPageRequest $request
     * @param \Course\Repositories\CourseRepository $courseRepository
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postIndex(
        $id,
        CreateCourseLandingPageRequest $request,
        CourseRepository $courseRepository,
        MediaRepository $mediaRepository,
        TagRepository $tagRepository
    )
    {
        try {
            /**
             * Update in course table
             */
            $course = $request->only(['name', 'slug']);
            $courseRepository->update($course, $id);

            /**
             * Update in course_ldp table
             */
            $userId = Auth::id();

            $tagId = array();
            if (isset($request->tags) && !empty($request->tags)) {
                $tags = explode(',', $request->tags);
                foreach ($tags as $tag) {
                    $check = $tagRepository->findByField('name', $tag);
                    if ($check->isEmpty()) {
                        $t = $tagRepository->create([
                            'name' => $tag,
                            'slug' => $tag,
                            'author' => $userId
                        ]);
                    } else {
                        $t = $check->first();
                    }
                    array_push($tagId, $t->id);
                }
            }

            $ldp = $request->except(['_token', 'name', 'slug', 'tags', 'course_id']);
            //upload image
            if ($request->file('thumbnail')) {
                $urlImage = $mediaRepository->uploadImage($userId, $request->file('thumbnail'));
                $ldp['thumbnail'] = $urlImage;
            }
            //upload video
            if ($request->file('video_promo')) {
                $video = $mediaRepository->uploadVideo($userId, $request->file('video_promo'));
                $ldp['video_promo'] = $video;
            }

            $course = $this->repository->updateOrCreate([
                'course_id' => $request->get('course_id')
            ], $ldp);

//            $course->getTag()->sync([5,6,7]);
            $course->getTag()->sync($tagId);

            return redirect()->back()->with(FlashMessage::returnMessage('edit'));

        } catch (\Exception $e) {
            return $e->getMessage();
            //return redirect()->back()->withErrors(config('messages.error'));
        }

    }

    /**
     * @param TagRepository $tagRepository
     * @return array
     */
    public function getTagAuto(TagRepository $tagRepository)
    {
        $tags = $tagRepository->all();
        $tagArr = [];
        foreach ($tags as $t) {
            $tagArr[] = $t->name;
        }
        return $tagArr;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePromovideo($id)
    {
        $this->repository->removePromoVideo($id);
        return redirect()->back()->with(FlashMessage::returnMessage('edit'));
    }
}