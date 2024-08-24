<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsInfo extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'VisitNumber',
        'CommentNumber',
        'NewsID',
        'Date',
        'NewsCategoryID',
        'NewsTitle',
        'TileUrl',
        'Thumbimage',
        'IsActive',
    ];
}
