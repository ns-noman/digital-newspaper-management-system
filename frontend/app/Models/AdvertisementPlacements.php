<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertisementPlacements extends Model
{
    use HasFactory;

    protected $table = 'advertisement_placements';

    public function activeOrder(){
		return $this->hasOne('App\Models\AdvertisementOrders', 'placement_id', 'id')->where('start_date', '<=', date('Y-m-d H:i:s'))->where('end_date', '>=', date('Y-m-d H:i:s'))->where('status', 1)->orderBy('id', 'desc');
	}

}
