<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/10/2018
 * Time: 11:17 AM
 */

namespace Course\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCourseRequest extends FormRequest
{
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
			'name' => 'required',
			'slug' => 'required|unique:course,slug',
			'author' => 'required'
		];
	}
	
	/**
	 * @return array
	 */
	public function messages()
	{
		return [
			'name.required' => 'Tên Khóa đào tạokhông được bỏ trống',
			'slug.required' => 'Slug Khóa đào tạokhông được bỏ trống',
			'slug.unique' => 'Slug Khóa đào tạođã được sử dụng',
			'author.required' => 'Tác giả Khóa đào tạokhông được bỏ trống'
		];
	}
}