<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/12/2018
 * Time: 9:54 AM
 */

namespace Course\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCourseLandingPageRequest extends FormRequest
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
		$id = intval($this->get('course_id'));
		return [
			'name' => 'required',
			'slug' => 'required|unique:classlevel,slug,'.$id.',id',
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
		];
	}
}