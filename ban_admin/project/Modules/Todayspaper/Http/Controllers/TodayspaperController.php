<?php

namespace Modules\Todayspaper\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Modules\CacheControlls\Http\Controllers\CacheControllsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Redis;
use DB;
use Auth;
use Session;
use Validator;
use App\Models\FacebookStickers;
use App\Models\Articles;
use App\Models\ArticleDetails;
use App\Models\ArticlePhotos;
use App\Models\ArticleCategories;
use App\Models\Categories;

class TodayspaperController extends Controller
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
    public function index()
    {
    	$data['articles'] = $this->getArticles();

        # common controller #
    	$commonController = new CommonController;
    	$data['categories'] = $commonController->getCategoriesPrint();
    	return view('todayspaper::index', $data);
    }


    public function unpublishedList(){
    	# common controller #
    	$commonController = new CommonController;
    	$data['categories'] = $commonController->getCategoriesPrint();

    	if(isset($_GET['date']) && !empty($_GET['date'])){
    		$data['articles'] = $this->getArticles('draft');
    	}
    	return view('todayspaper::unpublished-list', $data);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
    	# common controller #
    	$commonController = new CommonController;
    	$data['categories'] = $commonController->getCategoriesPrint();
    	return view('todayspaper::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request){

    	$validator = Validator::make($request->all(), [
    		'publish_date' => 'required',
    		'categories' => 'required',
    		'shoulder.*' => 'string|between:0,500|nullable',
    		'headline.*' => 'string|between:1,70|nullable',
    		'hanger.*' => 'string|between:0,500|nullable',
    		'reporter.*' => 'string|between:0,500|nullable',
    		'body.*' => 'string|nullable',
    		'image.*' => 'image|nullable',
    		'image_caption.*' => 'string|between:0,2000|nullable',
    	]);

    	if ($validator->fails()){
    		return redirect()->route('Todayspaper Create')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
    	}

    	try{
    		DB::beginTransaction();

    		$now = $request->publish_date.' 00:00:00';
    		$tableController = new TableController;
    		$tableController->createRequiredFolders($now);

    		# common controller #
    		$commonController = new CommonController;

    		if(!empty($request->headline) && (count($request->headline)>0)){
    			foreach ($request->headline as $key => $headline) {
    				if(!empty($headline)){
                    # article store #
    					$articleData = new Articles;
    					$articleData->category_id = $request->categories;
    					$articleData->shoulder = !empty($request->shoulder[$key]) ? $request->shoulder[$key] : Null;
    					$articleData->headline = preg_replace("/\xEF\xBB\xBF/", "", $request->headline[$key]);
    					$articleData->hanger = !empty($request->hanger[$key]) ? $request->hanger[$key] : Null;
    					$articleData->reporter = !empty($request->reporter[$key]) ? trim($request->reporter[$key]) : Null;

    					$articleData->description = !empty($request->body[$key]) ? strip_tags(implode(' ', array_slice(explode(' ', $request->body[$key]), 0, 25))) : Null;
    					$articleData->news_type = 2;
    					$articleData->home_status = 1;
    					$articleData->status = 0;
    					$articleData->created_by = Auth::user()->id;
    					$articleData->created_at = $now;
    					$articleData->order_id = $this->orderID();
    					$articleData->save();
                    # article store end #

                    # article detail store #
    					if(!empty($articleData->id)){
    						$articleDetailData = new ArticleDetails;
    						$articleDetailData->article_id = $articleData->id;
    						$articleDetailData->body = !empty($request->body[$key]) ? $request->body[$key] : Null;
    						$articleDetailData->save();
    					}
                    # article detail store end #

                    # article categories store #
    					if(!empty($articleData->id) && !empty($request->categories)){
    						$articleCategoryData = new ArticleCategories;
    						$articleCategoryData->article_id = $articleData->id;
    						$articleCategoryData->category_id = $request->categories;
    						$articleCategoryData->save();

    						$articleCategoryData = new ArticleCategories;
    						$articleCategoryData->article_id = $articleData->id;
    						$articleCategoryData->category_id = 1;
    						$articleCategoryData->save();
    					}
                    # article categories store end #

                    # article photo store #
    					if(!is_null($request->file('image')[$key])){
    						$image = $request->file('image')[$key];
    						$base_name = preg_replace('/\..+$/', '', $image->getClientOriginalName());
    						$base_name = explode(' ', $base_name);
    						$base_name = implode('-', $base_name);
    						$image_name = $base_name."-".uniqid().".".$image->getClientOriginalExtension();

    						$widthLarge = 995;
    						$heightLarge = 560;
    						$widthMedium = 400;
    						$heightMedium = 224;
    						$widthSmall = 200;
    						$heightSmall = 112;

    						## upload photos
    						$resizedImagePath = $commonController->compressAndResize($image, 'tempfiles/', $image_name, 80, $widthLarge, $heightLarge);
    						$savingPath = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($now));
    						Storage::disk(env('DISK'))->putFileAs($savingPath, $resizedImagePath, $image_name);

    						$resizedImagePathMedium = $commonController->compressAndResize($image, 'tempfiles/medium/', $image_name, 80, $widthMedium, $heightMedium);
    						$savingPathMedium = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($now)).'medium/';
    						Storage::disk(env('DISK'))->putFileAs($savingPathMedium, $resizedImagePathMedium, $image_name);

    						$resizedImagePathSmall = $commonController->compressAndResize($image, 'tempfiles/small/', $image_name, 80, $widthSmall, $heightSmall);
    						$savingPathSmall = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($now)).'small/';
    						Storage::disk(env('DISK'))->putFileAs($savingPathSmall, $resizedImagePathSmall, $image_name);

    						# thumbnail and social thumbnail
    						$thumbnail = $image_name;
    						$social_thumbnail = Null;
    						if(!empty($request->meta_sticker)){
    							$stickerInfo = FacebookStickers::where('id', $request->meta_sticker)->first();
    							if(!empty($stickerInfo)){
    								$sticker = env('UploadsLink').'uploads/fbstickers/'.$stickerInfo->sticker;
    								$generatedSocialThumb = $commonController->generateImageWithLogo($resizedImagePath, $sticker, 'tempfiles/social-thumbnail/', $image_name);

    								$savingPath = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($now)).'social-thumbnail/';
    								Storage::disk(env('DISK'))->putFileAs($savingPath, $generatedSocialThumb, $image_name);
    								$social_thumbnail = $image_name;
    							}
    						}
    						DB::table('articles')->where('id', $articleData->id)->update(['thumbnail' => str_replace(".webp", ".jpg", $thumbnail), 'social_thumbnail' => str_replace(".webp", ".jpg", $social_thumbnail)]);


								# unlink temp files
    						if(file_exists($resizedImagePath)){ 
    							unlink($resizedImagePath);
    						}
    						if(file_exists($resizedImagePathMedium)){ 
    							unlink($resizedImagePathMedium);
    						}
    						if(file_exists($resizedImagePathSmall)){ 
    							unlink($resizedImagePathSmall);
    						}
    						if(file_exists($generatedSocialThumb)){ 
    							unlink($generatedSocialThumb);
    						}

    						$articlePhotoData = new ArticlePhotos;
    						$articlePhotoData->article_id = $articleData->id;
    						$articlePhotoData->image = $image_name;
    						$articlePhotoData->image_caption = $request->image_caption[$key];
    						$articlePhotoData->status = 1;
    						$articlePhotoData->created_by = $articleData->created_by;
    						$articlePhotoData->created_at = $articleData->created_at;
    						$articlePhotoData->save();
    					}
                    # article photo store end #


                  ## news hit count store
    					$savingPath = env('NewAssetFolderPath').'news_hit/'.date('Y/m/d/', strtotime($now)).$articleData->id.'.txt';
    					Storage::disk(env('DISK'))->put($savingPath, 0);
                  ## news hit count store end

    				}
    			}
    		}

    		DB::commit();
    		return redirect()->route('Todayspaper Create')->with('success_message', 'Todayspaper articles has been created successfully.');

    	}catch(\Exception $e){
    		DB::rollback();
    		return redirect()->route('Todayspaper Create')->with('error_message', 'Todayspaper articles has not been created. Error : '.$e->getMessage());
    	}
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function bulkCreate()
    {
        # common controller #
    	$commonController = new CommonController;
    	$data['categories'] = $commonController->getCategoriesPrint();
    	return view('todayspaper::bulk-create', $data);
    }

    public function bulkStore(Request $request){

    	$validator = Validator::make($request->all(), [
    		'publish_date' => 'required',
    		'categories' => 'required',
    		'newsFile' => 'required',
    	]);

    	if ($validator->fails()){
    		return redirect()->route('Todayspaper Bulk Create')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
    	}

    	try{
    		DB::beginTransaction();

        $now = $request->publish_date.' 00:00:00';
        $processedNewsList = Null;

        $txtFile = \File::get($request->newsFile);
        $explodeTxtFile = explode('break', $txtFile);
        if (!empty($explodeTxtFile) && (count($explodeTxtFile)>0)) {
         foreach ($explodeTxtFile as $key => $textNews) {
          if(!empty($textNews)){
           $explodeNewsText = explode(PHP_EOL, $textNews);
           if(!empty($explodeNewsText[2])){

            $processedNewsList[$key] = array(
             'shoulder' => !empty($explodeNewsText[1]) ? $explodeNewsText[1] : Null,
             'headline' => !empty($explodeNewsText[2]) ? $explodeNewsText[2] : Null,
             'hanger' => !empty($explodeNewsText[3]) ? $explodeNewsText[3] : Null,
             'reporter' => !empty($explodeNewsText[4]) ? $explodeNewsText[4] : Null,
           );
            $detail = array_slice($explodeNewsText, 5);
            $processedNewsList[$key]['detail'] = '<p>'.implode('</p><p>', $detail).'</p>';
          }

        }
      }
    }


    if(!empty($processedNewsList) && (count($processedNewsList)>0)){
      $processedNewsList = array_reverse($processedNewsList);
      
      foreach ($processedNewsList as $key => $list) {

                # article store #
        $articleData = new Articles;
        $articleData->category_id = $request->categories;
        $articleData->shoulder = !empty($list['shoulder']) ? $list['shoulder'] : Null;
        $articleData->headline = !empty($list['headline']) ? $list['headline'] : Null;
        $articleData->hanger = !empty($list['hanger']) ? $list['hanger'] : Null;
        $articleData->reporter = !empty($list['reporter']) ? $list['reporter'] : Null;

        $articleData->description = !empty($list['detail']) ? strip_tags(implode(' ', array_slice(explode(' ', $list['detail']), 0, 25))) : Null;
        $articleData->news_type = 2;
        $articleData->home_status = 1;
        $articleData->status = 0;
        $articleData->created_by = Auth::user()->id;
        $articleData->created_at = $now;
        $articleData->order_id = $this->orderID();
        $articleData->save();
                # article store end #

                # article detail store #
        if(!empty($articleData->id)){
         $articleDetailData = new ArticleDetails;
         $articleDetailData->article_id = $articleData->id;
         $articleDetailData->body = !empty($list['detail']) ? $list['detail'] : Null;
         $articleDetailData->save();
       }
                # article detail store end #

                # article categories store #
       if(!empty($articleData->id) && !empty($request->categories)){
         $articleCategoryData = new ArticleCategories;
         $articleCategoryData->article_id = $articleData->id;
         $articleCategoryData->category_id = $request->categories;
         $articleCategoryData->save();

         $articleCategoryData = new ArticleCategories;
         $articleCategoryData->article_id = $articleData->id;
         $articleCategoryData->category_id = 1;
         $articleCategoryData->save();
       }
                # article categories store end #

                ## news hit count store
       $savingPath = env('NewAssetFolderPath').'news_hit/'.date('Y/m/d/', strtotime($now)).$articleData->id.'.txt';
       Storage::disk(env('DISK'))->put($savingPath, 0);
                ## news hit count store end

       $arrayData[] = $articleData;

     }
   }

   DB::commit();
   return redirect()->route('Todayspaper')->with('success_message', 'Todayspaper articles has been created successfully.');

 }catch(\Exception $e){
  DB::rollback();
  return redirect()->route('Todayspaper Bulk Create')->with('error_message', 'Todayspaper articles has not been created. Error : '.$e->getMessage());
}

}



public function bulkUpdate(Request $request){
 if (isset($request->bulkStatus) && !empty($request->ids) && (count($request->ids)>0)) {
  if($request->bulkStatus == 'swapOrder'){
   $order_ids = Null;
   foreach($request->ids as $key => $value){
    $explode = explode(',', $value);
    $order_ids[] = $explode[1];
  }
  arsort($order_ids);

  $count = 0;
  foreach($order_ids as $key => $order_id){
    $explode = explode(',', $request->ids[$count]);
    $id = $explode[0];
    $dataInfo = Articles::find($id);
    $dataInfo->order_id = $order_id;
    $dataInfo->updated_by = Auth::user()->id;
    $dataInfo->updated_at = date('Y-m-d H:i:s');
    $dataInfo->save();
    $count++;
  }
}

elseif($request->bulkStatus == "releaseArticle"){
 foreach($request->ids as $articleIds){
  $id = explode(",", $articleIds);
  $article = DB::table('articles')->where('id', $id[0])->update(['editor_taken' => Null, 'editor_taken_at' => Null]);
}
}

elseif($request->bulkStatus == "lead"){
 $id = explode(",", $request->ids[0]);
 $articleIDs[] = $id[0];
 $this->generateDisplayNews($articleIDs, 'lead');
}

elseif($request->bulkStatus == "top"){
 $selectedIds = Null;
 foreach($request->ids as $key => $articleID){
  $id = explode(",", $articleID);
  $selectedIds[] = $id[0];
}
$articleIDs = $selectedIds;
$this->generateDisplayNews($articleIDs, 'top');
}

elseif($request->bulkStatus == "no_placement"){
 foreach($request->ids as $articleIds){
  $id = explode(",", $articleIds);
  $article = DB::table('articles')->where('id', $id[0])->update(['display_position' => Null, 'display_order_id' => Null]);
}
}

elseif($request->bulkStatus == "publish"){
 foreach($request->ids as $articleIds){
  $id = explode(",", $articleIds);
  $article = DB::table('articles')->where('id', $id[0])->update(['status' => 1]);
}
}

elseif($request->bulkStatus == "unpublish"){
 foreach($request->ids as $articleIds){
  $id = explode(",", $articleIds);
  $article = DB::table('articles')->where('id', $id[0])->update(['status' => 0]);
}
}

elseif($request->bulkStatus == "remove"){
 foreach($request->ids as $articleIds){
  $id = explode(",", $articleIds);
  $article = DB::table('articles')->where('id', $id[0])->update(['status' => 2]);
}
}

elseif($request->bulkStatus == "publishArticlePrint"){
 $categories = Null;
 if(!empty($request->publishDate)){
  foreach($request->ids as $articleIds){
   $id = explode(",", $articleIds);
   $article = DB::table('articles')->where('id', $id[0])->update(['status' => 1]);
   $categories[] = $id[1];
 }
 if(!empty($categories) && (count($categories)>0)){
   asort($categories);
   $todaysCategories = implode(',', array_unique($categories));
   $todayspaperDate = array(
    'publish_date' => $request->publishDate,
    'categories' => $todaysCategories,
    'created_by' => Auth::user()->id, 
    'created_at' => date("Y-m-d H:i:s"),
  );
   DB::table('article_todayspaper_date')->insert($todayspaperDate);
 }

                    # redis regenrate
 $cacheController = new CacheControllsController;
 $cacheController->redisGenerateCategorySectionNews($categories);
 $cacheController->redisRegenerateNewsList();
                    # redis regenrate
}
}


elseif($request->bulkStatus == "updatePrintNewsPhoto"){
 $commonController = new CommonController;

 if(!empty($request->ids) && (count($request->ids)>0)){
  foreach($request->ids as $articleIds){
   $ids = explode(",", $articleIds);
   $id = $ids[0];
   $articleInfo = DB::table('articles')->where('articles.id', $id)->select('articles.id', 'articles.created_at')->first();

    				# article photo store #
   if(!is_null($request->file('images')[$id]) && !empty($articleInfo)){
    $now = $articleInfo->created_at;

    $image = $request->file('images')[$id];
    $base_name = preg_replace('/\..+$/', '', $image->getClientOriginalName());
    $base_name = explode(' ', $base_name);
    $base_name = implode('-', $base_name);
    $image_name = $base_name."-".uniqid().".".$image->getClientOriginalExtension();

    $widthLarge = 995;
    $heightLarge = 560;
    $widthMedium = 400;
    $heightMedium = 224;
    $widthSmall = 200;
    $heightSmall = 112;

    						## upload photos
    $resizedImagePath = $commonController->compressAndResize($image, 'tempfiles/', $image_name, 80, $widthLarge, $heightLarge);
    $savingPath = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($now));
    Storage::disk(env('DISK'))->putFileAs($savingPath, $resizedImagePath, $image_name);

    $resizedImagePathMedium = $commonController->compressAndResize($image, 'tempfiles/medium/', $image_name, 80, $widthMedium, $heightMedium);
    $savingPathMedium = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($now)).'medium/';
    Storage::disk(env('DISK'))->putFileAs($savingPathMedium, $resizedImagePathMedium, $image_name);

    $resizedImagePathSmall = $commonController->compressAndResize($image, 'tempfiles/small/', $image_name, 80, $widthSmall, $heightSmall);
    $savingPathSmall = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($now)).'small/';
    Storage::disk(env('DISK'))->putFileAs($savingPathSmall, $resizedImagePathSmall, $image_name);

    						# thumbnail and social thumbnail
    $thumbnail = $image_name;
    $social_thumbnail = Null;
    if(!empty($request->meta_sticker)){
     $stickerInfo = FacebookStickers::where('id', $request->meta_sticker)->first();
     if(!empty($stickerInfo)){
      $sticker = env('UploadsLink').'uploads/fbstickers/'.$stickerInfo->sticker;
      $generatedSocialThumb = $commonController->generateImageWithLogo($resizedImagePath, $sticker, 'tempfiles/social-thumbnail/', $image_name);

      $savingPath = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($now)).'social-thumbnail/';
      Storage::disk(env('DISK'))->putFileAs($savingPath, $generatedSocialThumb, $image_name);
      $social_thumbnail = $image_name;
    }
  }
  DB::table('articles')->where('id', $articleInfo->id)->update(['thumbnail' => str_replace(".webp", ".jpg", $thumbnail), 'social_thumbnail' => str_replace(".webp", ".jpg", $social_thumbnail)]);


								# unlink temp files
  if(file_exists($resizedImagePath)){ 
   unlink($resizedImagePath);
 }
 if(file_exists($resizedImagePathMedium)){ 
   unlink($resizedImagePathMedium);
 }
 if(file_exists($resizedImagePathSmall)){ 
   unlink($resizedImagePathSmall);
 }
 if(file_exists($generatedSocialThumb)){ 
   unlink($generatedSocialThumb);
 }

 $articlePhotoData = new ArticlePhotos;
 $articlePhotoData->article_id = $articleInfo->id;
 $articlePhotoData->image = $image_name;
 $articlePhotoData->image_caption = Null;
 $articlePhotoData->status = 1;
 $articlePhotoData->created_by = Auth::user()->id;
 $articlePhotoData->created_at = date('Y-m-d H:i:s');
 $articlePhotoData->save();
}
                    # article photo store end #
}
}
}


        	# redis regenrate
$cacheController = new CacheControllsController;
$cacheController->redisGenerateDisplayedNews();
        	# redis regenrate

            # server cache
$cacheController->clearServerUrlCache(env('WEBSITE'));
$cacheController->clearServerUrlCache(env('WEBSITE').'todays-paper');
            # server cache

return redirect()->back()->with('success_message', 'Success! Action Applied Successfully.');
}
return redirect()->back()->with('error_message', 'Alert! Error Applying Action.');
}


public function generateDisplayNews($articleIDs, $displayType=Null){
 if(!empty($articleIDs) && (count($articleIDs)>0)){

  if(empty($displayType)){
   foreach($articleIDs as $key => $selectedId){
    DB::table('articles')->where('id', $selectedId)->update(['display_position' => Null, 'display_order_id' => Null]);
  }
}

elseif($displayType == "lead"){
 $order = 0;
 $selectedIds = $articleIDs[0];
 $displayedArticles = DB::table('articles')->orderBy('articles.display_position', 'asc')->orderBy('articles.display_order_id', 'asc')->where('articles.id', '!=', $selectedIds)->whereIn('articles.display_position', ['lead', 'top'])->get();

 if(!empty($selectedIds)){
  $order++;
  DB::table('articles')->where('id', $selectedIds)->update(['display_position' => 'lead', 'display_order_id' => $order]);
}
if(!empty($displayedArticles)){
  foreach($displayedArticles as $key => $displayedArticle){
   $order++;
   if($order <= 10){
    DB::table('articles')->where('id', $displayedArticle->id)->update(['display_position' => 'top', 'display_order_id' => $order]);
  }else{
    DB::table('articles')->where('id', $displayedArticle->id)->update(['display_position' => Null, 'display_order_id' => Null]);
  }
}
}
}

elseif($displayType == "top"){
 $selectedIds = $articleIDs;
 $order = 0;
 $displayedArticles = DB::table('articles')->orderBy('articles.display_position', 'asc')->orderBy('articles.display_order_id', 'asc')->whereNotIn('articles.id', $selectedIds)->where('articles.display_position', 'top')->get();

 if(!empty($selectedIds)){
  foreach($selectedIds as $key => $selectedId){
   $order++;
   DB::table('articles')->where('id', $selectedId)->update(['display_position' => 'top', 'display_order_id' => $order]);
 }
}
if(!empty($displayedArticles)){
  foreach($displayedArticles as $key => $displayedArticle){
   $order++;
   if($order <= 10){
    DB::table('articles')->where('id', $displayedArticle->id)->update(['display_position' => 'top', 'display_order_id' => $order]);
  }else{
    DB::table('articles')->where('id', $displayedArticle->id)->update(['display_position' => Null, 'display_order_id' => Null]);
  }
}
}
}
}
return 'done';
}


public function getArticles($postType = Null){
 $paginationAmount = isset($_GET['paginationAmount']) && !empty($_GET['paginationAmount']) ? $_GET['paginationAmount'] : 10;

 $articles = Articles::select('articles.*')->where('articles.news_type', 2)->where('articles.status', '!=', 2)
 ->when(isset($_GET['date']) && !empty($_GET['date']), function ($query) {
  $query->whereDate('articles.created_at', '=', $_GET['date']);
})
 ->when(isset($_GET['newsId']) && !empty($_GET['newsId']), function ($query) {
  $query->where('articles.id', $_GET['newsId']);
})
 ->when(isset($_GET['headline']) && !empty($_GET['headline']), function ($query) {
  $query->where('articles.headline', 'like', '%'.$_GET['headline'].'%');
})
 ->when(isset($_GET['reporter']) && !empty($_GET['reporter']), function ($query) {
  $query->where('articles.reporter', 'like', '%'.$_GET['reporter'].'%');
})
 ->when(isset($_GET['dateFrom']) && !empty($_GET['dateFrom']), function ($query) {
  $query->whereDate('articles.created_at', '>=', $_GET['dateFrom']);
})
 ->when(isset($_GET['dateTo']) && !empty($_GET['dateTo']), function ($query) {
  $query->whereDate('articles.created_at', '<=', $_GET['dateTo']);
})
 ->when(isset($_GET['category']) && !empty($_GET['category']), function ($query) {
  $query->leftJoin('article_categories', 'article_categories.article_id', '=', 'articles.id')->where('article_categories.category_id', $_GET['category']);
})
 ->orderBy('articles.order_id', 'desc');

 if($postType == 'draft'){
  $articles = $articles->get();
}else{
  $articles = $articles->simplePaginate($paginationAmount);
}

return $articles;
}

public function orderID(){
 $orderIDInfo = Articles::select('articles.order_id')->orderBy('order_id', 'desc')->first();
 if(!empty($orderIDInfo)){
  $orderID = $orderIDInfo->order_id+1;
}else{
  $orderID = 1;
}
return $orderID;
}

public function generateUrlTitle($title){
 $urlTitle = str_replace(" ", "-", preg_replace('/([%\$!-_;:,.#\'"@*]+)/','', trim(strip_tags($title))));
 $urlTitle = str_replace("‘", "", $urlTitle);
 $urlTitle = str_replace("’", "", $urlTitle);
 $urlTitle = str_replace("---", "-", $urlTitle);
 $urlTitle = str_replace("--", "-", $urlTitle);
 $bom = pack('H*','EFBBBF');
 $urlTitle = preg_replace("/^$bom/", '', $urlTitle);
 return $urlTitle;
}


}
