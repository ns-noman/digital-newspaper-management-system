<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{

    protected $table = 'locations';
    public $timestamps = false;

    public function divisionInfo(){
        return $this->hasOne('App\Models\Locations', 'id', 'division');
    }

    public function districtInfo(){
        return $this->hasOne('App\Models\Locations', 'id', 'district');
    }

    public function createdBy(){
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function updatedBy(){
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}
