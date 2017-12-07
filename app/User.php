<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Hash;

class User extends Authenticatable
{
    use Notifiable;
    protected $fillable = ['email', 'password', 'remember_token', 'role_id', 'employee_id'];

    public function setPasswordAttribute($input)
    {
        if ($input)
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }

    public function setRoleIdAttribute($input)
    {
        $this->attributes['role_id'] = $input ? $input : null;
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

}
