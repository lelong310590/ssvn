<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/12/2018
 * Time: 3:40 PM
 */

namespace Course\Repositories;

use Course\Models\CourseCurriculumItems;
use Course\Models\CurriculumProgress;
use Media\Models\Media;
use MultipleChoices\Models\Question;
use Prettus\Repository\Eloquent\BaseRepository;

class CourseCurriculumItemsRepository extends BaseRepository
{
    public function model()
    {
        // TODO: Implement model() method.
        return CourseCurriculumItems::class;
    }

    /**
     * Get all section with course_id
     *
     * @param $id
     *
     * @return mixed
     */
    public function getAllSection($id)
    {
        $section = $this->orderBy('index', 'asc')->findWhere([
            'course_id' => $id
        ])->all();

        $media = new Media();
        $question = new Question();

        foreach ($section as $s) {
            if ($s['type'] == 'lecture') {
                $s['content'] = $media->where('curriculum_item', $s['id'])->first();
                $s['resource'] = $media->orderBy('created_at', 'asc')
                    ->where('curriculum_item', $s['id'])
                    ->where('type', '!=', 'video/mp4')
                    ->get();
            } else if ($s['type'] == 'quiz' || $s['type'] == 'test') {
                $s['content'] = $question->orderBy('index', 'asc')->where('curriculum_item', $s['id'])->get();
                $s['resource'] = null;
            } else {
                $s['content'] = [];
                $s['resource'] = null;
            }

            $s['onEdit'] = false;
            $s['show'] = false;
            $s['show'] = false;
            $s['onEditQuestion'] = false;
            $s['showContent'] = false;
            $s['showEditor'] = false;
            $s['showVideoContent'] = false;
            $s['displayQuizForm'] = false;
            $s['displayTestForm'] = false;
            $s['showResourceContent'] = false;
        }

        return $section;
    }

    /**
     * Add new section to db
     * @param $data
     *
     * @return array|mixed
     */
    public function addSection($data, $userid)
    {
        $qty = $this->findWhere([
            'course_id' => $data['course_id']
        ])->count();

        $data['index'] = $qty;

        $newSection = $this->create($data);

        $parentSectionId = 0;

        if ($data['type'] != 'section') {
            $parentSection = $this->orderBy('index', 'desc')
                ->findWhere([
                    'type' => 'section',
                    ['index', '<', $newSection->index],
                    'course_id' => $data['course_id']
                ])->first();

            $parentSectionId = (!empty($parentSection)) ? $parentSection->id : 0;

            $this->update([
                'parent_section' => $parentSectionId
            ], $newSection->id);

            $process = new CurriculumProgress;
            $process->course_id = $data['course_id'];
            $process->curriculum_id = $newSection->id;
            $process->student = $userid;
            $process->save();
        }

        $newSection['onEdit'] = false;
        $newSection['content'] = [];
        $newSection['displayLectureAddForm'] = false;
        $newSection['onEditQuestion'] = false;
        $newSection['displayQuizForm'] = false;
        $newSection['displayTestForm'] = false;
        $newSection['status'] = 'disable';
        $newSection['show'] = false;
        $newSection['showContent'] = false;
        $newSection['showEditor'] = false;
        $newSection['showVideoContent'] = false;
        $newSection['showResourceContent'] = false;
        $newSection['resource'] = [];
        $newSection['parent_section'] = $parentSectionId;
        $newSection['preview'] = 'disable';

        return $newSection;
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    public function updateItem($data)
    {
        $newItem = $this->update($data, $data['id']);
        return $newItem;
    }

    /**
     * @param $data
     */
    public function onSortEnd($data, $oldIndex, $newIndex)
    {
        $theLastSection = null;
        foreach ($data as $k => $value) {
            $update = ['index' => $k];
            if ($theLastSection && $value['type'] != 'section') {
                $update['parent_section'] = $theLastSection['id'];
                if ($value['status'] == 'active') {
                    $check_status ++;
                }
            } else {
                $update['parent_section'] = 0;
            }
            $this->update($update, $value['id']);
            if ($value['type'] == 'section') {
                if (isset($check_status)) {
                    if (!$check_status) {
                        $this->update(['status' => 'disable'], $theLastSection['id']);
                    } else {
                        $this->update(['status' => 'active'], $theLastSection['id']);
                    }
                }
                $theLastSection = $value;
                $check_status = 0;
            }
        }
        if (isset($check_status)) {
            if (!$check_status) {
                $this->update(['status' => 'disable'], $theLastSection['id']);
            } else {
                $this->update(['status' => 'active'], $theLastSection['id']);
            }
        }
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    public function updateDescription($data)
    {
        $item = $this->update([
            'description' => $data['description']
        ], $data['value']['id']);
        return $item;
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    public function updateStatus($data)
    {
        try {
            $status = $data['value']['status'];

            if ($status == 'disable') {
                $status = 'active';
            } else if ($status == 'active') {
                $status = 'disable';
            }

            //cap nhat trang thai curriculum truoc
            $item = $this->update([
                'status' => $status
            ], $data['value']['id']);

            $item['onEdit'] = false;
            $item['content'] = [];
            $item['displayLectureAddForm'] = false;
            $item['onEditQuestion'] = false;
            $item['displayQuizForm'] = false;
            $item['displayTestForm'] = false;
            $item['show'] = true;
            $item['showContent'] = false;
            $item['showEditor'] = false;
            $item['showVideoContent'] = false;
            $item['showResourceContent'] = false;
            $item['resource'] = [];

            //Cap nhat trang thai section
            $section = $this->orderBy('index', 'desc')
                ->findWhere([
                    'course_id' => $data['value']['course_id'],
                    'type' => 'section',
                    ['index', '<', $item->index]
                ])->first(); //Lay ra section chan dau

            if (empty($section)) {
                return [
                    'section' => [
                        'id' => 0,
                        'status' => false
                    ]
                ];
            }

            $nextSection = $this->orderBy('index', 'desc')
                ->findWhere([
                    'course_id' => $data['value']['course_id'],
                    'type' => 'section',
                    ['index', '>', $section->index]
                ])->first(); //Lay ra section chan = [];
            if (!empty($nextSection)) { // Truong hop co nhieu hon 1 lecture
                $otherLecture = $this->findWhere([
                    'course_id' => $data['value']['course_id'],
                    ['type', '!=', 'section'],
                    ['index', '>', $section->index],
                    ['index', '<', $nextSection->index]
                ])->all(); // Cac lecture o giua
            } else {
                $otherLecture = $this->findWhere([
                    'course_id' => $data['value']['course_id'],
                    ['type', '!=', 'section'],
                    ['index', '>', $section->index]
                ])->all();
            }

            //kiem tra lecture duoc active
            $sectionStatus = 'disable';
            foreach ($otherLecture as $l) {
                if ($l->status == 'active') {
                    $sectionStatus = 'active';
                    break;
                }
            }

            $newSection = $this->update([
                'status' => $sectionStatus
            ], $section->id);

            return [
                'section' => [
                    'id' => $newSection->id,
                    'status' => $sectionStatus
                ]
            ];

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function updatePreview($data)
    {
        $preview = $data['value']['preview'];
        if ($preview == 'disable') {
            $preview = 'active';
        } else if ($preview == 'active') {
            $preview = 'disable';
        }

        $item = $this->update([
            'preview' => $preview
        ], $data['value']['id']);

        $item['onEdit'] = false;
        $item['content'] = [];
        $item['displayLectureAddForm'] = false;
        $item['onEditQuestion'] = false;
        $item['show'] = true;
        $item['showContent'] = false;
        $item['showEditor'] = false;
        $item['showVideoContent'] = false;
        $item['displayQuizForm'] = false;
        $item['displayTestForm'] = false;
        $item['showResourceContent'] = false;
        $item['resource'] = [];
        return $item;
    }

    public function createSectionForTest($course ,$name)
    {
        $data = [
            'course_id' => $course->id,
            'name' => $name,
            'index' => 0,
            'type' => 'section',
        ];

        $this->create($data);
        return null;
    }
}