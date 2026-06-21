<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSubscribed extends Model
{
    use HasFactory;

    protected $table = 'customer_subscribed_news';
    public $timestamps = false;

}
