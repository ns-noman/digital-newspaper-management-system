<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
	protected $table = 'articles';
	public $timestamps = false;

	public function articleCategories()
	{
		return $this->hasMany('App\Models\ArticleCategories', 'article_id', 'id');
	}

	public function parentCategory()
	{
		return $this->hasOne('App\Models\Categories', 'id', 'category_id');
	}


	public function editorTaken(){
		return $this->hasOne('App\Models\User', 'id', 'editor_taken');
	}

	public function provedBy(){
		return $this->hasOne('App\Models\User', 'id', 'proved_id');
	}

	public function marketingPersonInfo(){
		return $this->hasOne('App\Models\MarketingPersons', 'id', 'marketing_person_id');
	}

	public function marketingCompanyInfo(){
		return $this->hasOne('App\Models\MarketingCompanies', 'id', 'marketing_company_id');
	}

	public function createdBy(){
		return $this->hasOne('App\Models\User', 'id', 'created_by');
	}

	public function updatedBy(){
		return $this->hasOne('App\Models\User', 'id', 'updated_by');
	}

}
