<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'ParentID',
        'Caption',
        'SEOCaption',
        'ParentName',
        'Priority',
        'IsActive',
        'Image',
        'CategoryGroupID',
        'UserID',
    ];
}
