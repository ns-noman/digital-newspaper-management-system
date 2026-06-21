<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    use HasFactory;

    protected $table = 'articles';

    public function articleUrlCategory(){
        return $this->hasOne('App\Models\Categories', 'id', 'category_id');
    }

    public function articleParentCategory(){
    	return $this->hasOne('App\Models\ArticleCategories', 'article_id', 'id')->where('type', 1);
    }

    public function articleChildCategory(){
        return $this->hasOne('App\Models\ArticleCategories', 'article_id', 'id')->where('type', 2);
    }

    public function subCategories(){
    	return $this->hasMany('App\Models\Categories', 'parent', 'category_id')->where('status', 1)->orderBy('order_id', 'asc');
    }

    public function articlePhotos(){
    	//return $this->hasMany('App\Models\ArticlePhotos', 'article_id', 'id')->where('status', 1)->orderBy('id', 'asc');
        return $this->hasMany('App\Models\ArticlePhotos', 'article_id', 'id')->orderBy('id', 'asc');
    }

    public function articleDetails(){
    	return $this->hasOne('App\Models\ArticleDetails', 'article_id', 'id');
    }
    
    public function authorInfo(){
    	return $this->hasOne('App\Models\Authors', 'id', 'author_id');
    }

    public function articleTopics(){
        return $this->hasMany('App\Models\ArticleTopics', 'article_id', 'id');
    }

    public function incidentInfo(){
        return $this->hasOne('App\Models\Incidents', 'id', 'incident_id');
    }

    public function archivedTopicInfo(){
        return $this->hasOne('App\Models\ArchivedTopics', 'id', 'archived_topic_id');
    }

    public function liveupdateNews(){
        return $this->hasMany('App\Models\LiveUpdates', 'article_id', 'id')->where('status', 1)->orderBy('order_id', 'desc');
    }

}
