<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $fillable = [
		'employee_id', 'days', 'date', 'date_range', 'basic', 'holiday', 'cola', 'overtime_pay', 'overtime_pay_night', 'bonus', 'allowance', 'gross',
		'tax', 'loan', 'philhealth', 'pag_ibig', 'sss', 'cash_advance', 'late', 'total_deductions', 'net_pay',	
	];

    public function employee(){
    	return $this->belongsTo(Employee::class);
    }

    public function contributions(){
        return $this->belongsToMany(Contribution::class, 'contribution_salary', 'contribution_id', 'salary_id');
    }
}
