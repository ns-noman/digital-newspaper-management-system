<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
	protected $table = 'categories';
	public $timestamps = false;

	public function childCategories(){
		return $this->hasMany('App\Models\Categories', 'parent', 'id')->where('status', '!=', 2)->orderBy('order_id', 'asc');
	}

	public function childCategoriesActive(){
		return $this->hasMany('App\Models\Categories', 'parent', 'id')->where('status', 1)->orderBy('order_id', 'asc');
	}

	public function activeChildCategories(){
		return $this->hasMany('App\Models\Categories', 'parent', 'id')->where('status', 1)->orderBy('sub_hierarchy', 'asc');
	}

	public function parentInfo(){
		return $this->hasOne('App\Models\Categories', 'id', 'parent');
	}

	public function createdBy(){
		return $this->hasOne('App\Models\User', 'id', 'created_by');
	}

	public function updatedBy(){
		return $this->hasOne('App\Models\User', 'id', 'updated_by');
	}
}