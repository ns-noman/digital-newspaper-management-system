<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeInitialsType extends Model
{
    protected $table = 'employee_initial_types';
    public $timestamps = false;

    public function createdBy(){
    	return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function updatedBy(){
    	return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}