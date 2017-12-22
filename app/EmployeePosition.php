<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeePosition extends Model
{
    protected $fillable = ['department_id', 'employee_id', 'position', 'rate'];

    public function department()
    {
      return $this->belongsTo(EmployeeDepartment::class, 'department_id');
    }

    public function employee()
    {
      return $this->belongsTo(Employee::class, 'employee_id');
    }
}
