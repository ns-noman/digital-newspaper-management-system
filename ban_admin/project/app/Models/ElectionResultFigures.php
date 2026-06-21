<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectionResultFigures extends Model
{
    protected $table = 'election_result_figures';
    public $timestamps = false;

    public function electionInfo(){
    	return $this->hasOne('App\Models\ElectionResults', 'id', 'election_result_id');
    }

    public function createdBy(){
    	return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function updatedBy(){
    	return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}