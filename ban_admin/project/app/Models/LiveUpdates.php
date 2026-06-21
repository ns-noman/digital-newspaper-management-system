<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveUpdates extends Model
{
    protected $table = 'live_updates';
    public $timestamps = false;

    public function articleInfo(){
    	return $this->hasOne('App\Models\Articles', 'id', 'article_id');
    }

    public function createdBy(){
    	return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function updatedBy(){
    	return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}