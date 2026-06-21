<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redis;
use Modules\CacheControlls\Http\Controllers\CacheControllsController;
use App\Http\Controllers\TableController;
use DB;
use Auth;
use Session;
use Validator;
use App\Models\Articles;
use App\Models\ArticlePhotos;
use App\Models\ArticleDetails;
use App\Models\ArticleCategories;
use App\Models\Categories;
use App\Models\Polls;
use App\Models\Incidents;
use App\Models\FacebookStickers;
use App\Models\Authors;
use App\Models\ArchivedTopics;
use App\Models\User;


class CommonController extends Controller
{

	public function getCategories(){
		$categories = DB::table('categories')->select('id', 'display_name', 'title', 'parent')->where('parent', 0)->where('status', 1)->where('edition', 'online')->orderBy('order_id', 'asc')->get();
		$otherCategories = DB::table('categories')->select('id', 'display_name', 'title', 'parent')->where('parent', '!=', 0)->where('status', 1)->where('edition', 'online')->orderBy('order_id', 'asc')->get();
		$otherCategories = $otherCategories->groupBy('parent');

		foreach ($categories as $key=>$category) {    
			if (isset($otherCategories[$category->id])) {
				$categories[$key]->childCategoriesActive = $otherCategories[$category->id];
			}
		}
		return $categories;
	}

	public function getCategoriesPrint(){
		$categories = DB::table('categories')->select('id', 'display_name', 'title', 'parent')->where('parent', 0)->where('status', 1)->where('edition', 'todayspaper')->orderBy('order_id', 'asc')->get();
		$otherCategories = DB::table('categories')->select('id', 'display_name', 'title', 'parent')->where('parent', '!=', 0)->where('status', 1)->where('edition', 'todayspaper')->orderBy('order_id', 'asc')->get();
		$otherCategories = $otherCategories->groupBy('parent');

		foreach ($categories as $key=>$category) {    
			if (isset($otherCategories[$category->id])) {
				$categories[$key]->childCategoriesActive = $otherCategories[$category->id];
			}
		}
		return $categories;
	}

	public function getDivisions(){
		$divisions = DB::table('locations')->where('status', '!=', 2)->where('type', 'division')->orderBy('title', 'asc')->get();
		return $divisions;
	}

	public function ajaxGetDistricts($id){
		$districts = DB::table('locations')->where('division', $id)->where('status', '!=', 2)->where('type', 'district')->orderBy('title', 'asc')->get();
		return view('ajaxDistricts')->with('districts', $districts);
	}

	public function ajaxGetUpazilas($id){
		$upazilas = DB::table('locations')->where('district', $id)->where('status', '!=', 2)->where('type', 'upazila')->orderBy('title', 'asc')->get();
		return view('ajaxUpazilas')->with('upazilas', $upazilas);
	}

	public function ajaxGetTopic(){
		$data = DB::table('archived_topics')->where('archived_topics.status', 1)
		->when(isset($_GET['searchTerm']) && !empty($_GET['searchTerm']), function ($query) {
			$query->where('archived_topics.topic_title', 'like', '%'.$_GET['searchTerm'].'%');
			$query->orWhere('archived_topics.topic_alternate_title', 'like', '%'.$_GET['searchTerm'].'%');
		})
		->select('archived_topics.id', 'archived_topics.topic_title', 'archived_topics.topic_alternate_title')->orderBy('archived_topics.order_id', 'desc')
		->when(empty($_GET['searchTerm']), function ($query) {
			$query->limit(50);
		})
		->get();

		// $result[] = array("id" => 0, "text" => '-- Select Topic --');
		$result = Null;
		if(!empty($data)){
			foreach ($data as $key => $value){
				$result[] = array("id" => $value->id, "text" => $value->topic_title.' - '.$value->topic_alternate_title);
			}
		}
		return response()->json($result);
	}

	public function removeThumbnail($articleId){
		DB::table('articles')->where('id', $articleId)->update(['thumbnail' => NULL]);
		return response()->json("success");
	}

	public function removeImageInfo($photoId){
		DB::table('article_photos')->where('id', $photoId)->delete();
		return response()->json("success");
	}

	public function textEditorImageUpload(Request $request){
		if(!is_null($request->file('image'))){
			$photo = $request->file('image');
			$base_name = preg_replace('/\..+$/', '', $photo->getClientOriginalName());
			$image_name = $base_name."-".uniqid().".".$photo->getClientOriginalExtension();
			$savingPath = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/');
			Storage::disk(env('DISK'))->putFileAs($savingPath, $photo, $image_name);
			$url = env('New_AssetLink').date('/Y/m/d/').$image_name;
			return $url;
		}
	}

	public function textEditorImageUploadedit(Request $request){
		if(!is_null($request->file('image'))){
			$photo = $request->file('image');
			$base_name = preg_replace('/\..+$/', '', $photo->getClientOriginalName());
			$image_name = $base_name."-".uniqid().".".$photo->getClientOriginalExtension();

			$savingPath = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($request->articleDate));
			Storage::disk(env('DISK'))->putFileAs($savingPath, $photo, $image_name);
			$url = env('New_AssetLink').date('/Y/m/d/', strtotime($request->articleDate)).$image_name;
			return $url;
		}
	}   

	public function compressAndResize($source_url, $destination_url, $imageName , $quality, $desired_width, $desired_height) {
		$info = getimagesize($source_url);
		if ($info['mime'] == 'image/jpeg'){
			list($width, $height) = $info;
			$src = imagecreatefromjpeg($source_url);
			$dst = imagecreatetruecolor($desired_width, $desired_height);
			imagecopyresampled($dst, $src, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
			imagejpeg($dst, $destination_url.$imageName, $quality);
		}

		elseif ($info['mime'] == 'image/png'){
			list($width, $height) = $info;
			$src = imagecreatefrompng($source_url);
			$dst = imagecreatetruecolor($desired_width, $desired_height);
			imagecopyresampled($dst, $src, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
			imagepng($dst, $destination_url.$imageName);
		}

		elseif ($info['mime'] == 'image/gif'){
			list($width, $height) = $info;
			$src = imagecreatefromgif($source_url);
			$dst = imagecreatetruecolor($desired_width, $desired_height);
			imagecopyresampled($dst, $src, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
			imagegif($dst, $destination_url.$imageName);
		}

		elseif ($info['mime'] == 'image/webp'){
			$imageName = explode('.webp', $imageName);
			$imageName = $imageName[0].'.jpg';
			list($width, $height) = $info;
			$src = imagecreatefromwebp($source_url);
			$dst = imagecreatetruecolor($desired_width, $desired_height);
			imagecopyresampled($dst, $src, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
			imagewebp($dst, $destination_url.$imageName, $quality);
		}

		return $destination_url.$imageName;
	}

	public function generateImageWithLogo($source, $sticker, $destination, $outputName){
		if(!empty($sticker)){
			$stickerInfo = explode('.',  $sticker);
			$stickerExtension = $stickerInfo[count($stickerInfo)-1];
			if($stickerExtension == 'jpg'){
				$logo = imagecreatefromjpeg($sticker);
			}elseif($stickerExtension == 'png'){
				$logo = imagecreatefrompng($sticker);
			}else{
				$logo = imagecreatefromgif($sticker);
			}
		}

		$info = getimagesize($source);
		if($info['mime'] == 'image/jpeg'){
			$photo = imagecreatefromjpeg($source);
		}elseif($info['mime'] == 'image/png'){
			$photo = imagecreatefrompng($source);
		}elseif($info['mime'] == 'image/gif'){
			$photo = imagecreatefromgif($source);
		}elseif($info['mime'] == 'image/webp'){
			$photo = imagecreatefromwebp($source);
		}

		$marge_right = 0;
		$marge_bottom = 0;
		$sx = imagesx($logo);
		$sy = imagesy($logo);
		imagecopy($photo, $logo, imagesx($photo) - $sx - $marge_right, imagesy($photo) - $sy - $marge_bottom, 0, 0, imagesx($logo), imagesy($logo));
		header('Content-type: image/jpeg');
		imagejpeg($photo, $destination.str_replace(".webp", ".jpg", $outputName));

		return $destination.str_replace(".webp", ".jpg", $outputName);
	}


	public function profile()
	{
		$data['profileInfo'] = User::where('id', Auth::user()->id)->first();
		return view('profile', $data);
	}

	public function profileUpdate(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'name' => 'required|string',
			'email' => 'required|email|unique:users,email,'.Auth::user()->id,
			'password' => 'nullable|string',
			'mobile' => 'nullable|string',
			'designation' => 'nullable|string',
			'department' => 'nullable|string',
			'image' => 'nullable|image',
		]);

		if ($validator->fails()) {
			return redirect()->route('Users Profile')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
		}


		try{
			DB::beginTransaction();

			$dataInfo = User::find(Auth::user()->id);
			$dataInfo->name = $request->name;
			$dataInfo->email = $request->email;
			if(!empty($request->password)){
				$dataInfo->password = \Hash::make($request->password);
			}
			$dataInfo->mobile = $request->mobile;
			$dataInfo->designation = $request->designation;
			$dataInfo->department = $request->department;
			$dataInfo->updated_by = Auth::user()->id;
			$dataInfo->updated_at = date('Y-m-d H:i:s');

			if(!empty($request->image)){
				if(!is_null($request->file('image'))){
					$image = $request->file('image');
					$fileName = time().'-'.uniqid().".".$image->getClientOriginalExtension();
					$savingPath = env('UploadsFolderPath').'users/';
					Storage::disk(env('DISK'))->putFileAs($savingPath, $image, $fileName);

					$dataInfo->image = $fileName;
				}
			}

			$dataInfo->save();

			DB::commit();

			return redirect()->route('Users Profile')->with('success_message', 'Profile has been updated successfully!.');

		}catch(Exception $e){
			DB::rollback();
			return redirect()->route('Users Profile')->with('error_message', 'Failed to update Profile!.');
		}
	}


	public function ajaxGetNewsUrl($newsId){
		$newsInfo = Articles::where('id', $newsId)->where('status', 1)->first();
		$news = Null;
		if(!empty($newsInfo)){
			$url = env('Domain').'/'.$newsInfo->parentCategory->title.'/'.$newsInfo->id;
			$news = '<a target="_blank" href="'.$url.'">'.$newsInfo->headline.'</a>';
		}
		return $news;
	}


	public static function GetBangla($text){
		$search_array= array("Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", ":", ",", "PM", "AM");
		$replace_array= array("শনিবার", "রোববার", "সোমবার", "মঙ্গলবার", "বুধবার", "বৃহস্পতিবার", "শুক্রবার", "১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০", "জানুয়ারি", "ফেব্রুয়ারি", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর", ":", ",", "পিএম", "এএম");
		$text = str_replace($search_array, $replace_array,$text);
		return $text;
	}


	public static function articleHit($createDate, $articleId, $hit)
	{
		$newsHitFile = '..'.env('UploadsFolderPath')."news_hit/".date('Y/m/d', strtotime($createDate))."/".$articleId.'.txt';
		if (file_exists($newsHitFile)) {
			$totalHit = \File::get($newsHitFile);
		}else {
			$newsHitPath = '..'.env('UploadsFolderPath')."news_hit/".date('Y/m/d/', strtotime($createDate));
			if(!is_dir($newsHitPath)){
				mkdir($newsHitPath,0777,true);
			}
			\File::put($newsHitPath.$articleId.'.txt','0');
			$totalHit = 0;
		}
		return $totalHit*5;
	}


	public static function userHit($userId, $dateFrom, $dateTo)
	{
		$articles = DB::table('articles')->where('articles.created_by', $userId)->where('articles.status', 1)
		->when(!empty($dateFrom), function ($query) use ($dateFrom) {
			$query->where('articles.created_at', '>=', $dateFrom);
		})
		->when(!empty($dateTo), function ($query) use ($dateTo) {
			$query->where('articles.created_at', '<=', $dateTo);
		})
		->select('articles.id', 'articles.created_at')->get();

		$totalHit = 0;
		if(!empty($articles)){
			foreach ($articles as $key => $article) {
				$newsHitFile = '..'.env('UploadsFolderPath')."news_hit/".date('Y/m/d', strtotime($article->created_at))."/".$article->id.'.txt';
				if (file_exists($newsHitFile)) {
					$hit = \File::get($newsHitFile);
					if($hit > 0){
						$totalHit = $totalHit+$hit;
					}
				}
			}
		}
		$totalInfo['totalHit'] = $totalHit*5;
		$totalInfo['totalNews'] = count($articles);
		return $totalInfo;
	}


	public static function initialHit($initialId, $dateFrom, $dateTo)
	{
		$articles = DB::table('article_mis')->where('article_mis.employee_initial_id', $initialId)->leftjoin('articles', 'articles.id', '=', 'article_mis.article_id')->where('articles.status', 1)
		->when(!empty($dateFrom), function ($query) use ($dateFrom) {
			$query->where('articles.created_at', '>=', $dateFrom);
		})
		->when(!empty($dateTo), function ($query) use ($dateTo) {
			$query->where('articles.created_at', '<=', $dateTo);
		})
		->select('articles.id', 'articles.created_at')->get();

		$totalHit = 0;
		if(!empty($articles)){
			foreach ($articles as $key => $article) {
				$newsHitFile = '..'.env('UploadsFolderPath')."news_hit/".date('Y/m/d', strtotime($article->created_at))."/".$article->id.'.txt';
				if (file_exists($newsHitFile)) {
					$hit = \File::get($newsHitFile);
					if($hit > 0){
						$totalHit = $totalHit+$hit;
					}
				}
			}
		}
		$totalInfo['totalHit'] = $totalHit*5;
		$totalInfo['totalNews'] = count($articles);
		return $totalInfo;
	}
	

}
