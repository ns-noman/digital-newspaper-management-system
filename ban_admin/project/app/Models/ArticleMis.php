<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleMis extends Model
{
    protected $table = 'article_mis';
    public $timestamps = false;

    public function initialInfo(){
    	return $this->hasOne('App\Models\EmployeeInitials', 'id', 'employee_initial_id');
    }

    public function initialTypeInfo(){
    	return $this->hasOne('App\Models\EmployeeInitialsType', 'id', 'employee_initial_type_id');
    }

    public function parentCategory()
	{
		return $this->hasOne('App\Models\Categories', 'id', 'category_id');
	}

    public function createdBy(){
    	return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
}