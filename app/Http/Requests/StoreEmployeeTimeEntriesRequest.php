<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeTimeEntriesRequest extends FormRequest
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
          'employee_id' => 'required',
          'date' => 'required|date_format:Y-m-d',
          'time_in' => 'required|date_format:H:i:s',
          'time_out' => 'required|date_format:H:i:s',
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required'  => 'Please dont leave it blank',
            'date.required'  => 'Please dont leave it blank',
            'date.date_format'  => 'date format: ex.(YYYY-MM-DD)',
            'time_in.required'  => 'Please dont leave it blank',
            'time_in.date_format'  => 'date format: ex.( Hour : Minute : Second)',
            'time_out.required'  => 'Please dont leave it blank',
            'time_out.date_format'  => 'date format: ex.( Hour : Minute : Second)',
        ];
    }
}
