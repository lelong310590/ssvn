<?php

namespace Course\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateLectureReportRequest
 * @package Course\Http\Requests
 */
class CreateLectureReportRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string',
            'lecture_id' => 'required|exists:course_curriculum_items,id',
            'course_id' => 'required|exists:course,id',
            'question_id' => 'nullable|exists:questions,id',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [];
    }
}