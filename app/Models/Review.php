<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'user_id',
        'order_id',
        'product_id',
        'review',
        'rating',
        'home_feature',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id')->select('id','name','email','image');
    }
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id')->select('id','product_code','product_title');
    }
}
