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
			'author' => 'required',
			'email' => 'email',
            'phone' => ['regex:/([\+84|84|0]+(3|5|7|8|9|1[2|6|8|9]))+([0-9]{8})\b/', 'unique:users,phone'],
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
			'slug.unique' => 'Slug Công ty đã được sử dụng',
			'author.required' => 'Tác giả Công ty không được bỏ trống',
            'phone.regex' => 'Số điện thoại không đúng',
            'phone.unique' => 'Số điện thoại này đã được sử dụng',
            'email.email' => 'Định dạng Email không đúng',
		];
	}
}