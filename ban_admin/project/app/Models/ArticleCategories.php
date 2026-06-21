<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleCategories extends Model
{
	protected $table = 'article_categories';
    public $timestamps = false;

    public function categoryInfo(){
		return $this->hasOne('App\Models\Categories', 'id', 'category_id');
	}

}
