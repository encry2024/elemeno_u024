<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            'employee_no'       => 'required',
            'fname'             => 'required',
            'mname'             => 'required',
            'lname'             => 'required',
            'address'           => 'required',
            'status'            => 'required',
            'dob'               => 'required|date_format:Y-m-d',
            'pob'               => 'required',
            'no_of_dependents'  => 'nullable|integer|max:30',
            'sss'               => 'nullable',
            'pag_ibig'          => 'nullable',
            'philhealth'        => 'nullable',
            'tin'               => 'nullable',
            'contact_no'        => 'required|min:11|max:11',
            'contact_no2'       => 'nullable|min:11|max:11',
            'email'             => 'required|email',
            'password'          => 'required|min:6',
        ];
    }
}
