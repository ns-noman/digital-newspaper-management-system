<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollDetails extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'OnlinepollID',
        'IPAddress',
        'Date',
    ];
}
