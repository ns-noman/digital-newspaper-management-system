<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleAuthors extends Model
{

    protected $table = 'article_authors';

    public function authorInfo(){
    	return $this->hasOne('App\Models\Authors', 'id', 'author_id');
    }

}
