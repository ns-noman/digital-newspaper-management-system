<?php

namespace Modules\LiveUpdates\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Modules\CacheControlls\Http\Controllers\CacheControllsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\CommonController;
use DB;
use Auth;
use Session;
use Validator;
use App\Models\LiveUpdates;
use App\Models\Articles;
use App\Models\ArticlePhotos;

class LiveUpdatesController extends Controller
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
    	$paginationAmount = isset($_GET['paginationAmount']) && !empty($_GET['paginationAmount']) ? $_GET['paginationAmount'] : 10;

    	$data['lists'] = LiveUpdates::whereIn('status', [1,2])
    	->when(isset($_GET['title']) && !empty($_GET['title']), function ($query) {
    		$query->where('title', 'like', '%'.$_GET['title'].'%');
    	})
    	->when(isset($_GET['article_id']) && !empty($_GET['article_id']), function ($query) {
    		$query->where('article_id', $_GET['article_id']);
    	})
    	->orderBy('order_id', 'desc')->simplePaginate($paginationAmount);

    	$data['articles'] = Articles::where('status', 1)->whereIn('liveupdate_status', [1,2])->orderBy('order_id', 'desc')->select('id', 'headline')->get();

    	return view('liveupdates::index', $data);
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'title' => 'required|string',
    		'body' => 'nullable|string',
    		'article_id' => 'required|numeric',
    		'image' => 'image|nullable',
    		'image_caption' => 'string|nullable',
    		'status' => 'numeric|between:-1,2',
    	]);

    	if ($validator->fails()) {
    		return redirect()->route('LiveUpdates')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
    	}

    	try{
    		DB::beginTransaction();

    		$dataInfo = new LiveUpdates;
    		$dataInfo->title = $request->title;
    		$dataInfo->article_id = $request->article_id;
    		$dataInfo->body = $request->body;
    		$dataInfo->order_id = $this->orderID();
    		$dataInfo->status = !empty($request->status) ? $request->status : -1;
    		$dataInfo->created_by = Auth::user()->id;
    		$dataInfo->created_at = date('Y-m-d H:i:s');

    		if(!empty($request->image)){
    			if(!is_null($request->file('image'))){
    				$image = $request->file('image');
    				$fileName = time().'-'.uniqid().".".$image->getClientOriginalExtension();
    				$savingPath = env('NewAssetFolderPath').'news_photos/liveupdates/';
    				Storage::disk(env('DISK'))->putFileAs($savingPath, $image, $fileName);
    				$dataInfo->image = $fileName;
    				$dataInfo->image_caption = $request->image_caption;
    			}
    		}

    		if(!empty($request->article_id) && !empty($request->replaceHeadline) && ($request->replaceHeadline == 1)){
    			DB::table('articles')->where('id', $dataInfo->article_id)->update(['headline' => $dataInfo->title]);
    		}

    		# news photos store #
    		# common controller #
    		$commonController = new CommonController;
    		if(!empty($request->article_id) && !empty($request->replaceThumbnail) && !empty($request->image) && ($request->replaceThumbnail == 1)){
    			$articleInfo = Articles::where('id', $request->article_id)->select('articles.id', 'articles.created_at')->first();
    			$now = $articleInfo->created_at;

    			if(!empty($articleInfo)){
    				$thumbnail = Null;
    				if(!is_null($request->file('image'))){
    					$image = $request->file('image');
    					$base_name = preg_replace('/\..+$/', '', $image->getClientOriginalName());
    					$base_name = explode(' ', $base_name);
    					$base_name = implode('-', $base_name);
    					$image_name = $base_name."-".uniqid().".".$image->getClientOriginalExtension();

    					$getSize = getimagesize($image);
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
    							$sticker = 'assets/images/fbstickers/'.$stickerInfo->sticker;
    							$generatedSocialThumb = $commonController->generateImageWithLogo($resizedImagePath, $sticker, 'tempfiles/social-thumbnail/', $image_name);

    							$savingPath = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($now)).'social-thumbnail/';
    							Storage::disk(env('DISK'))->putFileAs($savingPath, $generatedSocialThumb, $image_name);
    							$social_thumbnail = $image_name;
    						}
    					}
    					DB::table('articles')->where('id', $request->article_id)->update(['thumbnail' => str_replace(".webp", ".jpg", $thumbnail), 'social_thumbnail' => str_replace(".webp", ".jpg", $social_thumbnail)]);

    				#update photos
    					$articlePhotos = ArticlePhotos::where('article_id', $request->article_id)->where('status', 1)->orderBy('id', 'asc')->first();
    					$articlePhotos->image = $image_name;
    					$articlePhotos->image_caption = $request->image_caption;
    					$articlePhotos->article_id = $request->article_id;
    					$articlePhotos->status = 1;
    					if(!empty($articlePhotos)){
    						$articlePhotos->updated_by = Auth::user()->id;
    						$articlePhotos->updated_at = date("Y-m-d H:i:s");
    					}else{
    						$articlePhotos->created_by = Auth::user()->id;
    						$articlePhotos->created_at = date("Y-m-d H:i:s");
    					}
    					$articlePhotos->save();


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
    				}
    			}
    		}
    		# news photos store end #

    		$dataInfo->save();

    		DB::commit();

    		return redirect()->route('LiveUpdates')->with('success_message', 'LiveUpdates has been created successfully!.');

    	}catch(Exception $e){
    		DB::rollback();
    		return redirect()->route('LiveUpdates')->with('error_message', 'Failed to create LiveUpdates!.');
    	}
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'title' => 'required|string',
    		'body' => 'nullable|string',
    		'article_id' => 'required|numeric',
    		'image' => 'image|nullable',
    		'image_caption' => 'string|nullable',
    		'status' => 'numeric|between:-1,2',
    		'id' => 'required|numeric',
    	]);

    	if ($validator->fails()) {
    		return redirect()->route('LiveUpdates')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
    	}

    	try{
    		DB::beginTransaction();

    		$id = $request->id;
    		$dataInfo = LiveUpdates::find($id);
    		$dataInfo->title = $request->title;
    		$dataInfo->article_id = $request->article_id;
    		$dataInfo->body = $request->body;
    		$dataInfo->status = !empty($request->status) ? $request->status : -1;
    		$dataInfo->updated_by = Auth::user()->id;
    		$dataInfo->updated_at = date('Y-m-d H:i:s');
    		$dataInfo->image_caption = $request->image_caption;

    		if(!empty($request->image)){
    			if(!is_null($request->file('image'))){
    				$image = $request->file('image');
    				$fileName = time().'-'.uniqid().".".$image->getClientOriginalExtension();
    				$savingPath = env('NewAssetFolderPath').'news_photos/liveupdates/';
    				Storage::disk(env('DISK'))->putFileAs($savingPath, $image, $fileName);
    				$dataInfo->image = $fileName;
    			}
    		}

    		if(!empty($request->article_id) && !empty($request->replaceHeadline) && ($request->replaceHeadline == 1)){
    			DB::table('articles')->where('id', $dataInfo->article_id)->update(['headline' => $dataInfo->title]);
    		}


    		# news photos store #
    		# common controller #
    		$commonController = new CommonController;
    		if(!empty($request->article_id) && !empty($request->replaceThumbnail) && ($request->replaceThumbnail == 1)){
    			$articleInfo = Articles::where('id', $request->article_id)->select('articles.id', 'articles.created_at')->first();
    			$now = $articleInfo->created_at;

    			if(!empty($articleInfo)){
    				$thumbnail = Null;
    				if(!is_null($request->file('image'))){
    					$image = $request->file('image');
    					$base_name = preg_replace('/\..+$/', '', $image->getClientOriginalName());
    					$base_name = explode(' ', $base_name);
    					$base_name = implode('-', $base_name);
    					$image_name = $base_name."-".uniqid().".".$image->getClientOriginalExtension();

    					$getSize = getimagesize($image);
    					$widthLarge = $key == 0 ? 995 : $getSize[0];
    					$heightLarge = $key == 0 ? 560 : $getSize[1];
    					$widthMedium = $key == 0 ? 400 : $getSize[0];
    					$heightMedium = $key == 0 ? 224 : $getSize[1];
    					$widthSmall = $key == 0 ? 200 : $getSize[0];
    					$heightSmall = $key == 0 ? 112 : $getSize[1];

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
    							$sticker = 'assets/images/fbstickers/'.$stickerInfo->sticker;
    							$generatedSocialThumb = $commonController->generateImageWithLogo($resizedImagePath, $sticker, 'tempfiles/social-thumbnail/', $image_name);

    							$savingPath = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($now)).'social-thumbnail/';
    							Storage::disk(env('DISK'))->putFileAs($savingPath, $generatedSocialThumb, $image_name);
    							$social_thumbnail = $image_name;
    						}
    					}
    					DB::table('articles')->where('id', $request->article_id)->update(['thumbnail' => str_replace(".webp", ".jpg", $thumbnail), 'social_thumbnail' => str_replace(".webp", ".jpg", $social_thumbnail)]);

    				#update photos
    					$articlePhotos = ArticlePhotos::where('article_id', $request->article_id)->where('status', 1)->orderBy('id', 'asc')->first();
    					$articlePhotos->image = $image_name;
    					$articlePhotos->image_caption = $request->image_caption;
    					$articlePhotos->article_id = $request->article_id;
    					$articlePhotos->status = 1;
    					if(!empty($articlePhotos)){
    						$articlePhotos->updated_by = Auth::user()->id;
    						$articlePhotos->updated_at = date("Y-m-d H:i:s");
    					}else{
    						$articlePhotos->created_by = Auth::user()->id;
    						$articlePhotos->created_at = date("Y-m-d H:i:s");
    					}
    					$articlePhotos->save();


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
    				}

    				else{
    					#update photos
    					$articlePhotos = ArticlePhotos::where('article_id', $request->article_id)->where('status', 1)->orderBy('id', 'asc')->first();
    					if(!empty($articlePhotos)){
    						$articlePhotos->image_caption = $request->image_caption;
    						$articlePhotos->updated_by = Auth::user()->id;
    						$articlePhotos->updated_at = date("Y-m-d H:i:s");
    						$articlePhotos->save();
    					}
    				}

    			}
    		}
    		# news photos store end #

    		$dataInfo->save();

    		DB::commit();

    		return redirect()->route('LiveUpdates')->with('success_message', 'LiveUpdates has been updated successfully!.');

    	}catch(Exception $e){
    		DB::rollback();
    		return redirect()->route('LiveUpdates')->with('error_message', 'Failed to update LiveUpdates!.');
    	}
    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
    	if(!empty($id)){
    		$dataInfo = LiveUpdates::find($id);
    		$dataInfo->status = -1;
    		$dataInfo->updated_by = Auth::user()->id;
    		$dataInfo->updated_at = date('Y-m-d H:i:s');
    		$dataInfo->save();

    		return redirect()->back()->with('success_message', 'Success! Deleted Successfully.');
    	}
    	return redirect()->back()->with('error_message', 'Alert! Error Deleting Data.');
    }


    public function bulkUpdate(Request $request)
    {
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
    				$dataInfo = LiveUpdates::find($id);
    				$dataInfo->order_id = $order_id;
    				$dataInfo->updated_by = Auth::user()->id;
    				$dataInfo->updated_at = date('Y-m-d H:i:s');
    				$dataInfo->save();
    				$count++;
    			}
    		}else{
    			foreach($request->ids as $key => $ids){
    				$explode = explode(',', $ids);
    				$id = $explode[0];
    				$dataInfo = LiveUpdates::find($id);
    				$dataInfo->status = $request->bulkStatus;
    				$dataInfo->updated_by = Auth::user()->id;
    				$dataInfo->updated_at = date('Y-m-d H:i:s');
    				$dataInfo->save();
    			}
    		}

    		return redirect()->back()->with('success_message', 'Success! Action Applied Successfully.');
    	}
    	return redirect()->back()->with('error_message', 'Alert! Error Applying Action.');
    }


    public function orderID(){
    	$orderIDInfo = LiveUpdates::orderBy('order_id', 'desc')->first();
    	if(!empty($orderIDInfo)){
    		$orderID = $orderIDInfo->order_id+1;
    	}else{
    		$orderID = 1;
    	}
    	return $orderID;
    }

  }
