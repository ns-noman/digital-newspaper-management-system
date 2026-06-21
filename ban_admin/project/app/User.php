<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


	/**
     * Get the profile record associated with the user.
     */
    public function profile()
    {
        return $this->hasOne('App\Profile');
    }


    public function news()
    {
        if (isset($_GET['date_from']) && !empty($_GET['date_from']) && isset($_GET['date_to']) && !empty($_GET['date_to'])){
            return $this->hasMany('App\News', 'created_by', 'id')->where('status', 1)->whereDate('created_at', '>=', $_GET['date_from'])->whereDate('created_at', '<=', $_GET['date_to']);
        }
        return $this->hasMany('App\News', 'created_by', 'id')->where('status', 1);
    }
}
