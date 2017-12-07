<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
	protected $fillable = ['date', 'description', 'type'];
    public $timestamps = false;
}
