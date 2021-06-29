<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 8/1/2018
 * Time: 10:23 AM
 */

namespace Post\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostEditValidate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = intval($this->get('current_id'));
        return [
            'name' => 'required|min:3',
            'slug' => 'required|unique:post,slug,'.$id.',id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Thread title must not be blank',
            'name.min' => 'The title must be greater than 3 characters',
            'slug.required' => 'The post slug is not empty',
            'slug.unique' => 'This post slug has been used'
        ];
    }
}