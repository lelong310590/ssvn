<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 7/31/2018
 * Time: 2:32 PM
 */
namespace Post\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCreateValidate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'slug' => 'required|unique:post,slug'
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