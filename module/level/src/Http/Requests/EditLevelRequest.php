<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/7/2018
 * Time: 12:07 AM
 */

namespace Level\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditLevelRequest extends FormRequest
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
			'slug' => 'required|unique:level,slug,'.$id.',id',
			'editor' => 'required'
		];
	}
	
	/**
	 * @return array
	 */
	public function messages()
	{
		return [
			'name.required' => 'Tên trình độ không được bỏ trống',
			'slug.required' => 'Slug trình độ không được bỏ trống',
			'slug.unique' => 'Slug này đã tồn tại',
			'editor.required' => 'Người chỉnh sửa trình độ không được bỏ trống'
		];
	}
}