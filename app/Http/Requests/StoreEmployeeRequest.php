<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'employee_no'       => 'required|unique:employees',
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
            'email'             => 'required|email',
            'contact_no'        => 'required|min:11|max:11',
            'contact_no2'       => 'nullable|min:11|max:11',
            'email'             => 'required|email|unique:employees,email',
            'schedule'          => 'required',
            'working_status'    => 'required',
            'leave_entitlement' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'employee_no.required' => 'Please dont leave it blank',
            'fname.required' => 'Please dont leave it blank',
            'mname.required'  => 'Please dont leave it blank',
            'lname.required'  => 'Please dont leave it blank',
            'address.required'  => 'Please dont leave it blank',
            'status.required'  => 'Please dont leave it blank',
            'dob.required'  => 'Please dont leave it blank',
            'dob.date_format'  => 'date format: ex.(1990-01-31)',
            'pob.required'  => 'Please dont leave it blank',
        ];
    }
}
