<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['employee_no', 'fname', 'mname', 'lname', 'address', 'status', 'dob', 'pob', 'no_of_dependents', 
            'contact_no', 'contact_no2', 'email', 'sss', 'pag_ibig', 'philhealth', 'tin', 'working_status', 'schedule', 'leave_entitlement'];

    public function fullname(){
    	return $this->fname.' '.$this->mname.' '.$this->lname;
    }

    public function time_entries(){
    	return $this->hasMany(EmployeeTimeEntries::class, 'employee_id');
    }

    public function departments(){
    	return $this->belongsToMany(EmployeeDepartment::class, 'employee_positions', 'employee_id', 'department_id')
    		->withPivot(['position', 'rate']);
    }

    public function position(){
    	return $this->hasOne(EmployeePosition::class);
    }

    public function salaries(){
    	return $this->hasMany(Salary::class);
    }

    public function contributions(){
        return $this->hasMany(Contribution::class);
    }

    public function cash_advance(){
        return $this->hasMany(CashAdvance::class);
    }

    public function positions(){
        return $this->hasOne(EmployeePosition::class);
    }

    public function bonuses(){
        return $this->hasMany(Bonus::class);
    }

    public function overtimes(){
        return $this->hasMany(OvertimeRequest::class);
    }

    public function loan(){
        return $this->hasOne(Loan::class);
    }

    public function backpays(){
        return $this->hasMany(BackPay::class);
    }

    public function user(){
        return $this->hasOne(User::class);
    }

    public function leaves(){
        return $this->hasMany(Leave::class);
    }

    public function logs(){
        return $this->hasMany(Log::class);
    }

    public function allowances(){
        return $this->hasMany(Allowance::class);
    }
}
