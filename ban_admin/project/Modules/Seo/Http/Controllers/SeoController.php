<?php

namespace Modules\Seo\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Modules\CacheControlls\Http\Controllers\CacheControllsController;
use DB;
use Auth;
use Session;
use Validator;
use App\Models\Articles;

class SeoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    	$this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function postMeta()
    {
    	$paginationAmount = isset($_GET['paginationAmount']) && !empty($_GET['paginationAmount']) ? $_GET['paginationAmount'] : 10;

    	$lists = Articles::whereIn('articles.status', [1,2])
    	->when(isset($_GET['headline']) && !empty($_GET['headline']), function ($query) {
    		$query->where('articles.headline', 'like', '%'.$_GET['headline'].'%');
    	})
    	->when(isset($_GET['category']) && !empty($_GET['category']), function ($query) {
    		$query->leftjoin('article_categories', 'article_categories.article_id', '=', 'articles.id')->where('article_categories.category_id', $_GET['category']);
    	})
    	->orderBy('articles.order_id', 'desc')->simplePaginate($paginationAmount);

    	$this->attachParentCategory($lists);
    	$data['lists'] = $lists;
    	$data['categories'] = $this->getCategories();
    	return view('seo::post-meta', $data);
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function postMetaUpdate(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'meta_description.*' => 'nullable|string',
    		'keywords.*' => 'nullable|string',
    		'tags.*' => 'nullable|string',
    	]);

    	if ($validator->fails()) {
    		return redirect()->route('Seo Post Meta')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
    	}

    	try{
    		DB::beginTransaction();

    		if(!empty($request->articles) && (count($request->articles)>0)){
    			foreach ($request->articles as $key => $id) {
    				$dataInfo = Articles::find($id);
    				$dataInfo->description = $request->meta_description[$id];
    				$dataInfo->keywords = $request->keywords[$id];
    				$dataInfo->tags = $request->tags[$id];
    				$dataInfo->save();
    				DB::commit();

                    # redis regenrate
    				$cacheController = new CacheControllsController;
    				$cacheController->redisRegenerateNewsList($dataInfo->id);
                    # redis regenrate
    			}
    		}


    		return redirect()->route('Seo Post Meta')->with('success_message', 'Post Meta has been updated successfully!.');

    	}catch(Exception $e){
    		DB::rollback();
    		return redirect()->route('Seo Post Meta')->with('error_message', 'Failed to update Post Meta.');
    	}
    }


    public function getCategories(){
    	$categories = DB::table('categories')->select('id', 'display_name', 'parent')->where('parent', 0)->where('status', 1)->where('edition', 'online')->orderBy('order_id')->get();
    	$otherCategories = DB::table('categories')->where('parent', '!=', 0)->where('status', 1)->orderBy('order_id')->get();
    	$otherCategories = $otherCategories->groupBy('parent');

    	foreach ($categories as $key=>$category) {    
    		if (isset($otherCategories[$category->id])) {
    			$categories[$key]->subcategories = $otherCategories[$category->id];
    		}
    	}
    	return $categories;
    }


    public function attachParentCategory($articles){
    	foreach ($articles as $article) {
    		$article->categories = DB::table('categories')->select('categories.display_name', 'categories.title')->where('id', $article->category_id)->first();
    	}
    	return true;
    }

}
