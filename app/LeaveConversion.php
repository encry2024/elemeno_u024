<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveConversion extends Model
{
    protected $fillable = ['employee_id', 'date', 'unused_leave', 'amount'];

    public function employee(){
    	return $this->belongsTo(Employee::class);
    }
}
