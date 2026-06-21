<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectionResults extends Model
{
    protected $table = 'election_results';
    public $timestamps = false;

    public function figures(){
    	return $this->hasMany('App\Models\ElectionResultFigures', 'election_result_id', 'id')->where('status', '>=', 1)->orderBy('order_id', 'desc');
    }

    public function createdBy(){
    	return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function updatedBy(){
    	return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}