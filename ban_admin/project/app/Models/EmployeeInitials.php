<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeInitials extends Model
{
	protected $table = 'employee_initials';
	public $timestamps = false;

	public function createdBy(){
		return $this->hasOne('App\Models\User', 'id', 'created_by');
	}

	public function updatedBy(){
		return $this->hasOne('App\Models\User', 'id', 'updated_by');
	}
}