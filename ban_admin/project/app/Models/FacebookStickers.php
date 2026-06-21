<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacebookStickers extends Model
{
    protected $table = 'facebook_stickers';
    public $timestamps = false;

    public function createdBy(){
    	return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function updatedBy(){
    	return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}