<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportantLinks extends Model
{
    protected $table = 'important_links';
    public $timestamps = false;

    public function importantLinkCategoryInfo(){
    	return $this->hasOne('App\Models\ImportantLinkCategories', 'id', 'important_link_category_id');
    }

    public function createdBy(){
    	return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function updatedBy(){
    	return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}