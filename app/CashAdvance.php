<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashAdvance extends Model
{
    protected $fillable = [
    	'employee_id', 'amount', 'status',
    ];

    public function employee(){
    	return $this->belongsTo(Employee::class);
    }
}
