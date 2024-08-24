<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporter extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'ReporterName',
        'Email',
        'Image',
        'IsActive',
        'Address',
        'Contact',
        'NewsSection',
        'NewsBit',
        'Notes',
        'WebLink',
        'UserID'
    ];
}
