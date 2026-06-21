<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchiveArticles extends Model
{
    use HasFactory;

    protected $connection= 'archive_database';
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
        return $this->hasMany('App\Models\ArticlePhotos', 'article_id', 'id')->orderBy('id', 'asc');
    }

    public function articleDetails(){
    	return $this->hasOne('App\Models\ArticleDetails', 'article_id', 'id');
    }
    
    public function authorInfo(){
    	return $this->hasOne('App\Models\Authors', 'id', 'author_id');
    }

    public function incidentInfo(){
        return $this->hasOne('App\Models\Incidents', 'id', 'incident_id');
    }

    public function archivedTopicInfo(){
        return $this->hasOne('App\Models\ArchivedTopics', 'id', 'archived_topic_id');
    }

}
