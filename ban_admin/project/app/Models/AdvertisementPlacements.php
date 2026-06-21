<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertisementPlacements extends Model
{
    protected $table = 'advertisement_placements';
    public $timestamps = false;

    public function placementOrders(){
		return $this->hasMany('App\Models\AdvertisementOrders', 'placement_id', 'id')->whereDate('end_date', '>=', date('Y-m-d'))->where('status', '!=', 2)->orderBy('id', 'desc');
	}

    public function placementActiveOrder(){
		return $this->hasOne('App\Models\AdvertisementOrders', 'placement_id', 'id')->whereDate('end_date', '>=', date('Y-m-d'))->where('status', 1)->orderBy('id', 'desc');
	}

	public function createdBy(){
		return $this->hasOne('App\Models\User', 'id', 'created_by');
	}

	public function updatedBy(){
		return $this->hasOne('App\Models\User', 'id', 'updated_by');
	}

}
