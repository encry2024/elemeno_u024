<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeePositionRequest extends FormRequest
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
          'department_id' => 'required',
          'employee_id' => 'required',
          'position' => 'required',
          'rate' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'department_id.required' => 'Please dont leave it blank',
            'employee_id.required' => 'Please dont leave it blank',
            'position.required'  => 'Please dont leave it blank',
            'rate.required'  => 'Please dont leave it blank',
        ];
    }
}
