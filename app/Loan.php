<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = ['employee_id', 'date', 'amount', 'status', 'months', 'monthly_payment', 'request_status'];
    public $timestamps = false;

    public function employee(){
    	return $this->belongsTo(Employee::class);
    }

    public function payments(){
    	return $this->hasMany(Salary::class, 'employee_id');
    }
}
