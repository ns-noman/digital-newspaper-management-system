<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsPosition extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'PositionName',
        'UserID',
        'IsActive',
        'EntryDate',
    ];
}
