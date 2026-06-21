<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    use HasFactory;

    protected $table = 'departments';

    public function teams(){
        return $this->hasMany('App\Models\Authors', 'department_id', 'id')->where('status', 1)->orderBy('order_id', 'desc');
    }

}
