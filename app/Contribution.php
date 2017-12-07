<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    protected $fillable = ['employee_id', 'date', 'sss_employer', 'sss_employee', 'sss_total', 
    			'philc_employer', 'philc_employee', 'philc_total', 'hdmf'];

    public function salaries(){
    	return $this->belongsToMany(Salary::class, 'contribution_salary', 'contribution_id', 'salary_id');
    }
}
