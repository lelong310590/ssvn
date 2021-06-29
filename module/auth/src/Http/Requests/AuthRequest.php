<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/31/2017
 * Time: 10:47 PM
 */

namespace Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
			'email' => 'required|min:5',
			'password' => 'required'
		];
	}
	
	public function messages()
	{
		return [
			'email.required' => 'Tên đăng nhập không được bỏ trống',
			'email.min' => 'Độ dài tối thiểu cho tên đăng nhập là 5 ký tự',
			'password.required' => 'Mật khẩu không được bỏ trống'
		];
	}
}