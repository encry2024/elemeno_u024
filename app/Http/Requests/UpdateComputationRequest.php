<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateComputationRequest extends FormRequest
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
            'date' => 'required|date_format:Y-m-d',
            'date_range' => 'required',
            'basic' => 'required|numeric',
            'cola' => 'required|numeric',
            'overtime_pay' => 'required|numeric',
            'allowance' => 'required|numeric',
            'bonus' => 'required|numeric',
            'late' => 'required|numeric',
        ];
    }
}
