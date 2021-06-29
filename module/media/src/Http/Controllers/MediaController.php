<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/28/2018
 * Time: 11:12 PM
 */

namespace Media\Http\Controllers;

use Barryvdh\Debugbar\Controllers\BaseController;
use Course\Repositories\CourseCurriculumItemsRepository;
use Illuminate\Http\Request;
use Media\Repositories\MediaRepository;
use FFMpeg\FFProbe;
use Media\Models\Media;

class MediaController extends BaseController
{
    protected $repository;

    public function __construct(MediaRepository $mediaRepository)
    {
        $this->repository = $mediaRepository;
    }

    /**
     * @param \Illuminate\Http\Request                             $request
     * @param \Course\Repositories\CourseCurriculumItemsRepository $courseCurriculumItemsRepository
     *
     * @return array|mixed
     */
    public function upload(Request $request, CourseCurriculumItemsRepository $courseCurriculumItemsRepository)
    {
        $userid = $request->get('userid');
        $curriculum = $request->get('curriculum');

        //Change status of curriculum with have been new uploaded
        $c = $courseCurriculumItemsRepository->find($curriculum);
        $cur = $courseCurriculumItemsRepository->update(['status' => 'disable'],$c->id);

        $file = $request->file('file');
        $this->repository->removeOldContent($curriculum);
        $result = $this->repository->upload($userid, $file, $curriculum, $type = 'video');

        return response()->json([
            'video' => $result,
            'curriculum' => $cur
        ]);
    }

    /**
     * Api for media lib get list video unused
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function getListVideo(Request $request){
        $owner = $request->get('owner');
        $media = $this->repository->getListVideo($owner);
        return $media;
    }

    /**
     * Api for media lib delete video
     * @param \Illuminate\Http\Request $request
     *
     * @return string
     */
    public function delete(Request $request){
        $id = $request->get('id');
        try{
            $this->repository->deleteMedia($id);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Api for media lib, change curriculum item content
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function updateCuriculumVideo(Request $request, CourseCurriculumItemsRepository $courseCurriculumItemsRepository){
        try {
            $id = $request->get('id');
            $curitem = $request->curItem['id'];
            $owner = $request->owner;

            $oldMedia = $this->repository->findWhere([
                'curriculum_item' => $curitem,
            ])->first();

            if (!empty($oldMedia)) {
                $this->repository->update([ //set null to old media attached to this curriculum
                    'curriculum_item' => null
                ], $oldMedia->id);
            }

            $this->repository->update([ //update new media to this curriculum
                'curriculum_item' => $curitem
            ], $id);

            $curriculum = $courseCurriculumItemsRepository->update([
                'preview' => 'disable'
            ], $curitem);

            //return new media list
            $media = $this->repository->getListVideo($owner);

            return [
                'media' => $media,
                'curriculum' => $curriculum
            ];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param \Illuminate\Http\Request                             $request
     * @param \Course\Repositories\CourseCurriculumItemsRepository $courseCurriculumItemsRepository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadResource(Request $request, CourseCurriculumItemsRepository $courseCurriculumItemsRepository)
    {
        $userid = $request->get('userid');
        $curriculum = $request->get('curriculum');

        //Change status of curriculum with have been new uploaded
        $c = $courseCurriculumItemsRepository->find($curriculum);
        $cur = $courseCurriculumItemsRepository->update(['status' => 'disable'],$c->id);

        $file = $request->file('file');
        $result = $this->repository->upload($userid, $file, $curriculum, $type = 'resources');

        return response()->json([
            'resource' => $result,
            'curriculum' => $cur
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return string
     */
    public function deleteResource(Request $request)
    {
        $id = $request->get('id');
        try{
            $this->repository->deleteResource($id);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function setNullResource(Request $request)
    {
        $id = $request->get('id');
        try{
            $this->repository->setNullResource($id);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function getListResource(Request $request)
    {
        $owner = $request->get('owner');
        $media = $this->repository->getListResource($owner);
        return $media;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function updateResource(Request $request, CourseCurriculumItemsRepository $courseCurriculumItemsRepository) {
        $id      = $request->get( 'id' );
        $curitem = $request->curItem['id'];
        $owner   = $request->owner;

        $this->repository->update( [
            'curriculum_item' => $curitem
        ], $id );

        $media = $this->repository->getListResource( $owner );

        $curriculum = $courseCurriculumItemsRepository->update( [
            'preview' => 'disable'
        ], $curitem );

        return [
            'media'      => $media,
            'curriculum' => $curriculum
        ];
    }
}