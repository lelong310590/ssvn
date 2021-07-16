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
            'email' => 'email',
            'phone' => ['required', 'regex:/([\+84|84|0]+(3|5|7|8|9|1[2|6|8|9]))+([0-9]{8})\b/'],
            'last_name' => 'required',
            'citizen_identification' => 'required|min:10|max:12|unique:users,citizen_identification,'. $this->id,
            'dob' => 'required',
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
            'email.email' => 'Định dạng Email không đúng',
            're_password.required' => 'Mật khẩu nhập lại không được bỏ trống',
            'last_name.required' => 'Tên và tên đệm không được bỏ trống',
            'phone.required' => 'Số điện thoại không được bỏ trống',
            'phone.regex' => 'Số điện thoại không đúng',
            'citizen_identification.required' => 'CMND/CCCD không được bỏ trống',
            'citizen_identification.min' => 'Số CMND/CCCD không hợp lệ',
            'citizen_identification.max' => 'Số CMND/CCCD không hợp lệ',
            'citizen_identification.unique' => 'Số CMND/CCCD này đã tồn tại',
            'dob.required' => 'Ngày sinh không được bỏ trống'
		];
	}
}