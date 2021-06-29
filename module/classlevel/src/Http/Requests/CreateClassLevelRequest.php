<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 11:59 AM
 */

namespace ClassLevel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClassLevelRequest extends FormRequest
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
			'slug' => 'required|unique:classlevel,slug',
			'author' => 'required'
		];
	}
	
	/**
	 * @return array
	 */
	public function messages()
	{
		return [
			'name.required' => 'Tên lớp không được bỏ trống',
			'slug.required' => 'Slug lớp không được bỏ trống',
			'slug.unique' => 'Slug lớp đã được sử dụng',
			'author.required' => 'Tác giả lớp không được bỏ trống'
		];
	}
}