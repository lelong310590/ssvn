<?php
/**
 * ImportEmployerRequest.php
 * Created by: trainheartnet
 * Created at: 16/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace ClassLevel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportEmployerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rule = [
            'manager' => 'required',
            'excel_file' => 'required|mimes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        return $rule;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'manager.required' => 'Người quản lý không được bỏ trống',
            'excel_file.required' => 'File excel không được bỏ trống',
            'excel_file.mimes' => 'Định dạng file excel phải là .xlsx',
        ];
    }
}