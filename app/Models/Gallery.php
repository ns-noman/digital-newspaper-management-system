<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'Caption',
        'Detail',
        'Image',
        'MediumImage',
        'Thumbimage',
        'EntryDate',
        'Date',
        'IsActive',
        'UserID',
        'NewsCategoryID',
        'ParentCategoryID',
        'SubCategoryID',
        'CategoryName',
        'TagWord',
        'GalleryType',
        'Priority',
    ];
}
