<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackPay extends Model
{
	protected $table = 'backpays';
    protected $fillables = ['date_paid', 'amount', 'status'];

    public function employee(){
    	return $this->belongsTo(Employee::class);
    }
}
