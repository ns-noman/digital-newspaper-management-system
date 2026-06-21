<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportantLinkCategories extends Model
{
    protected $table = 'important_link_categories';
    public $timestamps = false;

    public function createdBy(){
    	return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function updatedBy(){
    	return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}