<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeDepartment extends Model
{
    protected $fillable = ['name'];

    public function positions(){
    	return $this->hasMany(EmployeePosition::class, 'department_id');
    }
}
