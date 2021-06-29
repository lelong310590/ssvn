<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 8/8/2018
 * Time: 12:51 AM
 */

namespace Menu\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuNodeValidate extends FormRequest
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
            'name' => 'required|min:3',
            'url' => 'required',
            'menu' => 'required|integer',
            'index' => 'required|integer'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The field Node Title must be present in the input data and not empty.',
            'name.min' => 'The field Node Title must have a minimum value 3 characters',
            'url.required' => 'The field Node Url validation must be present in the input data and not empty.',
            'menu.required' => 'The field Menu Position validation must be present in the input data and not empty.',
            'index.required' => 'The field Node Index validation must be present in the input data and not empty.',
            'menu.integer' => 'The field Node Index must be an integer.',
            'index.integer' => 'The field Node Index must be an integer.'
        ];
    }
}