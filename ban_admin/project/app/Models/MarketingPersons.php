<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketingPersons extends Model
{
    protected $table = 'marketing_persons';
    public $timestamps = false;

    public function createdBy(){
    	return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function updatedBy(){
    	return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}