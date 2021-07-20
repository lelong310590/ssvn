<?php
/**
 * ManagerRequest.php
 * Created by: trainheartnet
 * Created at: 20/07/2021
 * Contact me at: longlengoc90@gmail.com
 */


namespace Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagerRequest extends FormRequest
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
        $rule = [
            'manager' => 'required'
        ];

        $action = $this->get('action');

        if ($action != 'getall') {
            $rule['change_manager'] = 'not_in:'.$this->manager;
        }

        return $rule;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'manager.required' => 'Phải chọn quản lý để thực hiện thao tác điều chuyển',
            'change_manager.not_in' => 'Người lao động phải được chuyển sang quản lý khác người quản lý này',
        ];
    }
}