<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 1/4/2018
 * Time: 2:00 PM
 */

namespace Acl\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleValidate extends FormRequest
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
			'name' => 'required|unique:roles,name',
			'display_name' => 'required'
		];
	}
	
	/**
	 * @return array
	 */
	public function messages()
	{
		return [
			'name.required' => 'Slug vai trò không được bỏ trống',
			'name.unique' => 'Slug này đã được sử dụng',
			'display_name.required' => 'Tên vai trò không được bỏ trống'
		];
	}
}