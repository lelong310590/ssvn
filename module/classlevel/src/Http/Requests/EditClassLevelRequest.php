<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 2:33 PM
 */

namespace ClassLevel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditClassLevelRequest extends FormRequest
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
			'slug' => 'required|unique:classlevel,slug,'.$id.',id',
			'editor' => 'required'
		];
	}
	
	/**
	 * @return array
	 */
	public function messages()
	{
		return [
			'name.required' => 'Tên Công ty không được bỏ trống',
			'slug.required' => 'Slug Công ty không được bỏ trống',
			'slug.unique' => 'Slug này đã tồn tại',
			'editor.required' => 'Người chỉnh sửa Công ty không được bỏ trống'
		];
	}
}