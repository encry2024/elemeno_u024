<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeAttendanceRequest extends FormRequest
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
          'position_id' => 'required',
          'employee_id' => 'required',
          'work_types' => 'required',
          'date' => 'required',
          'time_in' => 'required',
          'time_out' => 'required',
          'work_hours' => 'required',
          'overtime' => 'required',
        ];
    }
}
