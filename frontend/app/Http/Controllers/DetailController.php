<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redis;
use App\Models\ArchiveArticles;
use App\Models\Articles;
use App\Models\ArticleCategories;
use App\Models\Categories;
use DB;
use Auth;

class DetailController extends Controller
{

	public function __construct()
	{
		# redis connection check
		// $this->redisConnStatus = env('REDIS_STATUS');
		// if($this->redisConnStatus == true){
		// 	try{
		// 		$redisConnection = Redis::connection();
		// 		$redisConnection->connect();
		// 		$this->redisConnStatus = true;
		// 	}catch(\Exception $e){
		// 		$this->redisConnStatus = false;
		// 	}
		// }
		# redis connection check end
		$this->redisConnStatus = false;
	}


	# detail page
	public function detail($category, $articleId, $urlTitle = Null){
		## common controller ##
		$commonController = new CommonController;
		$commonController->checkCategory($category);

		if($this->redisConnStatus == true){
			$articleListInRedis = Redis::get('latestNewsList');
			$articleListInRedis = unserialize($articleListInRedis);
		}
		
		try{
			DB::beginTransaction();
			$data['detailCount'] = 1;
			$data['categoryInfo'] = DB::table('categories')->where('title', $category)->first();

			if(!empty($articleListInRedis[$articleId])){
				$articleInfo = $articleListInRedis[$articleId];
			}else{
				if($articleId > env('Archived_NewsId')){
					$articleInfo = Articles::where('status', 1)->where('id', $articleId)->first();
				}else{
					$articleInfo = ArchiveArticles::where('status', 1)->where('id', $articleId)->first();
				}
			}

			if(empty($articleInfo)){
				abort(404);
			}

			$data['articleDetail'] = \App\Models\Helper::processArticle($articleInfo, 0);
			$data['articlePhotos'] = $articleInfo->articlePhotos;
			$data['articleDetails'] = $articleInfo->articleDetails;

			$data['advPlacements'] = $commonController->getAdvertisementPlacements();
			return view('detail', $data);
			
		}catch(\Exception $e){
			abort(404);
		}
	}


	# detail page
	public function detail2($category, $subcategory = Null, $articleId, $urlTitle = Null){
		$category = !empty($subcategory) ? $category.'/'.$subcategory : $category;
		## common controller ##
		$commonController = new CommonController;
		$commonController->checkCategory($category);

		if($this->redisConnStatus == true){
			$articleListInRedis = Redis::get('latestNewsList');
			$articleListInRedis = unserialize($articleListInRedis);
		}
		
		try{
			DB::beginTransaction();
			$data['detailCount'] = 1;
			$data['categoryInfo'] = DB::table('categories')->where('title', $category)->first();

			if(!empty($articleListInRedis[$articleId])){
				$articleInfo = $articleListInRedis[$articleId];
			}else{
				if($articleId > env('Archived_NewsId')){
					$articleInfo = Articles::where('status', 1)->where('id', $articleId)->first();
				}else{
					$articleInfo = ArchiveArticles::where('status', 1)->where('id', $articleId)->first();
				}
			}

			if(empty($articleInfo)){
				abort(404);
			}

			$data['articleDetail'] = \App\Models\Helper::processArticle($articleInfo, 0);
			$data['articlePhotos'] = $articleInfo->articlePhotos;
			$data['articleDetails'] = $articleInfo->articleDetails;

			$data['advPlacements'] = $commonController->getAdvertisementPlacements();
			return view('detail', $data);
			
		}catch(\Exception $e){
			abort(404);
		}
	}


	# ajax detail page
	public function ajaxDetail($articleId, $categoryId, $paginate){
		try{
			DB::beginTransaction();
			## common controller ##
			$commonController = new CommonController;

			$data['categoryInfo'] = DB::table('categories')->where('id', $categoryId)->first();
			$articleCategory = ArticleCategories::where('article_id', '!=', $articleId)->where('category_id', $categoryId)->orderBy('id', 'desc')->skip($paginate)->first();
			$articleInfo = $articleCategory->articleInfo;
			$data['articleDetail'] = \App\Models\Helper::processArticle($articleInfo, 0);
			$data['articlePhotos'] = $articleInfo->articlePhotos;
			$data['articleDetails'] = $articleInfo->articleDetails;
			$data['detailCount'] = $paginate+1;
			$data['mainArticleId'] = $articleId;
			return view('detail-ajax', $data);
		}catch(\Exception $e){
		}
	}


}
