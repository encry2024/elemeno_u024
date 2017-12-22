<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OvertimeRequest extends Model
{
    protected $fillable = ['employee_id', 'date', 'time_rendered', 'status'];

    public function employee(){
    	return $this->belongsTo(Employee::class);
    }
}
