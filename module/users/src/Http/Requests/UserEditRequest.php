<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 1/3/2018
 * Time: 11:09 AM
 */

namespace Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			're_password' => 'same:password',
			'first_name' => 'required',
		];
	}
	
	/**
	 * @return array
	 */
	public function messages()
	{
		return [
			're_password.same' => 'Mật khẩu nhắc lại không trùng',
			'first_name.required' => 'Họ không được bỏ trống',
		];
	}
}