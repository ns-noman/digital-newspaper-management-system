<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use DB;
use Auth;

class CategoryController extends Controller
{

	# category page
	public function category($category, $subcategory = Null){
		$category = !empty($subcategory) ? $category.'/'.$subcategory : $category;
		## common controller ##
		$commonController = new CommonController;
		$commonController->checkCategory($category);

		try{
			$categoryInfo = $commonController->getCategoryInfoByTitle($category);
			$data['categoryInfo'] = $categoryInfo;

			$parentCategoryInfo = $commonController->getCategoryInfo($categoryInfo->parent);
			$data['parentCategoryInfo'] = $parentCategoryInfo;

			$categoryPage = (!empty($categoryInfo) && $categoryInfo->title == 'todays-paper' || (!empty($parentCategoryInfo) && $parentCategoryInfo->title == 'todays-paper') ? 'todayspaper' : 'category');


			# todayspaper section
			if($categoryPage == 'todayspaper'){

				if($categoryInfo->title != 'todays-paper'){
					$data['categoryArticles'] = $commonController->getCategoryArticlesPage($categoryInfo->id, 10);
				}

				if(isset($_GET['date']) && !empty($_GET['date'])){
					$todayspaperInfo = DB::table('article_todayspaper_date')->where('publish_date', $_GET['date'])->orderBy('publish_date', 'desc')->first();
				}else{
					$todayspaperInfo = DB::table('article_todayspaper_date')->orderBy('publish_date', 'desc')->first();
				}
				$todayspaperCategories = !empty($todayspaperInfo) ? explode(',', $todayspaperInfo->categories) : Null;
				if(empty($todayspaperCategories)){
					abort(404);
				}

				$subCategories = DB::table('categories')->whereIn('id', $todayspaperCategories)->orderBy('order_id', 'asc')->get();
				$data['subCategories'] = $subCategories;

				$subCategoryArticles = Null;
				if(($categoryInfo->parent == 0) && !empty($subCategories) && (count($subCategories)>0)){
					foreach ($subCategories as $key => $subCat) {
						$subCategoryArticles[] = $commonController->getCategoryArticlesPage($subCat->id, 5);
					}
				}
				$data['subCategoryArticles'] = $subCategoryArticles;
				
			}

			# category section
			else{
				$subCategories = $commonController->getSubCategories($categoryInfo->parent == 0 ? $categoryInfo->id : $categoryInfo->parent);
				$data['subCategories'] = $subCategories;

				$data['categoryArticles'] = $commonController->getCategoryArticlesBySection($categoryInfo->id, 20);
				if($category == 'country'){
					$data['divisions'] = $commonController->getDivisions();
				}
			}
			
			
			return view('category-pages.'.$categoryPage, $data);

		}catch(\Exception $e){
			abort(404);
		}
	}


}
