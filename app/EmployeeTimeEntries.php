<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeTimeEntries extends Model
{
    protected $fillable = ['employee_id', 'work_types', 'date', 'time_in', 'time_out'];

    public function employee()
    {
      return $this->belongsTo(Employee::class, 'employee_id');
    }

}
