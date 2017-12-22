<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Month13 extends Model
{
    protected $table = 'month13';

    protected $fillable = ['employee_id', 'date', 'amount', 'tax'];

    public function employee(){
    	return $this->belongsTo(Employee::class);
    }
}
