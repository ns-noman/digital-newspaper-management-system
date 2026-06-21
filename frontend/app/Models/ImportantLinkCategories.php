<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportantLinkCategories extends Model
{
    protected $table = 'important_link_categories';
    public $timestamps = false;

    public function links(){
    	return $this->hasMany('App\Models\ImportantLinks', 'important_link_category_id', 'id')->where('status', 1)->orderBy('order_id', 'desc');
    }

    public function createdBy(){
    	return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function updatedBy(){
    	return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}