<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 1/4/2018
 * Time: 4:40 PM
 */

namespace Acl\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditRoleValidate extends FormRequest
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
			'display_name' => 'required'
		];
	}
	
	/**
	 * @return array
	 */
	public function messages()
	{
		return [
			'display_name.required' => 'Tên vai trò không được bỏ trống'
		];
	}
}