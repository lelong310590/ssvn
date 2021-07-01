<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/6/2018
 * Time: 1:21 PM
 */

namespace Subject\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditSubjectRequest extends FormRequest
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
		$id = intval($this->get('current_id'));
		return [
			'name' => 'required',
			'slug' => 'required|unique:subject,slug,'.$id.',id',
			'editor' => 'required',
		];
	}
	
	/**
	 * @return array
	 */
	public function messages()
	{
		return [
			'name.required' => 'Tên Chứng chỉ không được bỏ trống',
			'slug.required' => 'Slug Chứng chỉ không được bỏ trống',
			'slug.unique' => 'Slug Chứng chỉ đã được sử dụng',
			'editor.required' => 'Người chính sửa không được bỏ trống',
		];
	}
}