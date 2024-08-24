<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'AdsPositionID',
        'AdsUrl',
        'AdsDetail',
        'CustomerName',
        'StartDate',
        'EndDate',
        'UserID',
        'IsActive',
        'EntryDate',
    ];
    public function position()
    {
        return $this->belongsTo(AdsPosition::class, 'AdsPositionID');
    }
}
