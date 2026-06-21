<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleCategories extends Model
{
    use HasFactory;

    protected $table = 'article_categories';

    public function categoryInfo(){
    	return $this->hasOne('App\Models\Categories', 'id', 'category_id');
    }

    public function articleInfo(){
    	return $this->hasOne('App\Models\Articles', 'id', 'article_id')->where('status', 1);
    }

}
