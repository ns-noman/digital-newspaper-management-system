<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrontMenu extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'Caption',
        'MenuLink',
        'ParentID',
        'Priority',
        'IsActive',
        'LinkType',
        'MenuGroup',
        'Image',
        'UserID',
    ];
}
