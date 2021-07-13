<?php

namespace Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
	        'email' => 'email',
            'phone' => ['required', 'regex:/([\+84|84|0]+(3|5|7|8|9|1[2|6|8|9]))+([0-9]{8})\b/'],
	        'password' => 'required|min:6',
	        're_password' => 'required|same:password',
	        'first_name' => 'required',
	        'last_name' => 'required',
            'citizen_identification' => 'required|min:9|max:12|unique:users,citizen_identification',
            'dob' => 'required',
        ];
    }
	
	/**
	 * @return array
	 */
    public function messages()
    {
	    return [
		    'email.email' => 'Định dạng Email không đúng',
		    'password.required' => 'Mật khẩu không được bỏ trống',
		    'password.min' => 'Mật khẩu tối thiểu là 6 ký tự',
            're_password.required' => 'Mật khẩu nhập lại không được bỏ trống',
		    're_password.same' => 'Mật khẩu nhắc lại không trùng',
		    'first_name.required' => 'Họ không được bỏ trống',
		    'last_name.required' => 'Tên và tên đệm không được bỏ trống',
            'phone.required' => 'Số điện thoại không được bỏ trống',
            'phone.regex' => 'Số điện thoại không đúng',
            'citizen_identification.required' => 'CMND/CCCD không được bỏ trống',
            'citizen_identification.min' => 'Số CMND/CCCD không hợp lệ',
            'citizen_identification.max' => 'Số CMND/CCCD không hợp lệ',
            'citizen_identification.unique' => 'Số CMND/CCCD này đã tồn tại',
            'dob.requỉed' => 'Ngày sinh không được bỏ trống'
	    ];
    }
}
