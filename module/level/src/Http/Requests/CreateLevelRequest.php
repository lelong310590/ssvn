<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/6/2018
 * Time: 11:45 PM
 */

namespace Level\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateLevelRequest extends FormRequest
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
			'slug' => 'required|unique:level,slug',
			'author' => 'required'
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
			'slug.unique' => 'Slug trình độ đã được sử dụng',
			'author.required' => 'Tác giả trình độ không được bỏ trống'
		];
	}
}