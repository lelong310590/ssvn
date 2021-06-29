<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/6/2018
 * Time: 11:39 AM
 */

namespace Subject\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSubjectRequest extends FormRequest
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
			'slug' => 'required|unique:subject,slug',
			'author' => 'required',
			'icon' => 'required'
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
			'author.required' => 'Tác giả Chứng chỉ không được bỏ trống',
			'icon.required' => 'Icon cho Chứng chỉ không được bỏ trống'
		];
	}
}