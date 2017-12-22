<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    protected $fillable = [
    	'employee_id', 'type', 'amount', 'date',
    ];

    public function employee(){
    	return $this->belongsTo(Employee::class);
    }
}
