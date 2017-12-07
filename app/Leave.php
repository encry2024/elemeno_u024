<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = ['employee_id', 'date', 'days', 'reason', 'status'];

    public function employee(){
    	return $this->belongsTo(Employee::class);
    }
}
