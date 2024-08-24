<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Writer extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'WriterName',
        'Email',
        'Image',
        'IsActive',
        'Address',
        'Contact',
        'NewsSection',
        'NewsBit',
        'Notes',
        'WebLink',
        'UserID',
    ];
}
