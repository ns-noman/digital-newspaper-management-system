<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleTopics extends Model
{

    protected $table = 'article_topics';

    public function topicInfo(){
    	return $this->hasOne('App\Models\ArchivedTopics', 'id', 'topic_id');
    }

}
