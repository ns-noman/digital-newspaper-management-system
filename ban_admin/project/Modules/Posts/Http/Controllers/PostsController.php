<?php

namespace Modules\Posts\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redis;
use Modules\CacheControlls\Http\Controllers\CacheControllsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\CommonController;
use DB;
use Auth;
use Session;
use Validator;
use App\Models\User;
use App\Models\Articles;
use App\Models\ArticlePhotos;
use App\Models\ArticleDetails;
use App\Models\ArticleCategories;
use App\Models\ArticleMis;
use App\Models\Categories;
use App\Models\Polls;
use App\Models\Incidents;
use App\Models\FacebookStickers;
use App\Models\Authors;
use App\Models\ArchivedTopics;
use App\Models\EmployeeInitials;
use App\Models\EmployeeInitialsType;
use App\Models\ArticleAuthors;
use App\Models\ArticleTopics;
use App\Models\MarketingPersons;
use App\Models\MarketingCompanies;

class PostsController extends Controller
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
    	if(isset($_GET['articleId']) && !empty($_GET['articleId'])){
    		Articles::where('id', $_GET['articleId'])->where('editor_taken', Auth::user()->id)->update(['editor_taken' => Null, 'editor_taken_at' => Null]);
    	}

    	$data['articles'] = $this->getArticles();

        # common controller #
    	$commonController = new CommonController;
    	$data['categories'] = $commonController->getCategories();
    	return view('posts::index', $data);
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function myPost()
    {
    	if(isset($_GET['articleId']) && !empty($_GET['articleId'])){
    		Articles::where('id', $_GET['articleId'])->where('editor_taken', Auth::user()->id)->update(['editor_taken' => Null, 'editor_taken_at' => Null]);
    	}

    	$data['articles'] = $this->getArticles('my-post');

        # common controller #
    	$commonController = new CommonController;
    	$data['categories'] = $commonController->getCategories();
    	return view('posts::index', $data);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function leadtop()
    {
    	$data['articles'] = $this->getArticles('leadtop');

        # common controller #
    	$commonController = new CommonController;
    	$data['categories'] = $commonController->getCategories();
    	return view('posts::index', $data);
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function selected()
    {
    	$data['articles'] = $this->getArticles('selected');

        # common controller #
    	$commonController = new CommonController;
    	$data['categories'] = $commonController->getCategories();
    	return view('posts::index', $data);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function photos()
    {
    	$data['articles'] = $this->getArticles('photos');

        # common controller #
    	$commonController = new CommonController;
    	$data['categories'] = $commonController->getCategories();
    	return view('posts::index', $data);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function videos()
    {
    	$data['articles'] = $this->getArticles('videos');

        # common controller #
    	$commonController = new CommonController;
    	$data['categories'] = $commonController->getCategories();
    	return view('posts::index', $data);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function audios()
    {
    	$data['articles'] = $this->getArticles('audios');

        # common controller #
    	$commonController = new CommonController;
    	$data['categories'] = $commonController->getCategories();
    	return view('posts::index', $data);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function draft()
    {
    	$data['articles'] = $this->getArticles('draft');

        # common controller #
    	$commonController = new CommonController;
    	$data['categories'] = $commonController->getCategories();
    	return view('posts::index', $data);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function paidPost()
    {
    	$data['articles'] = $this->getArticles('paid');

        # common controller #
    	$commonController = new CommonController;
    	$data['categories'] = $commonController->getCategories();
    	return view('posts::index', $data);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
    	$data['incidents'] = DB::table('incidents')->where('status', 1)->orderBy('id', 'desc')->get();
    	$data['authors'] = DB::table('authors')->where('status', 1)->orderBy('order_id', 'desc')->get();
    	$data['metaStickers'] = FacebookStickers::where('status', 1)->orderBy('order_id', 'desc')->get();
    	$data['employeeInitials'] = EmployeeInitials::where('status', 1)->orderBy('order_id', 'desc')->get();
    	$data['types'] = EmployeeInitialsType::where('status', 1)->orderBy('order_id', 'desc')->get();
    	$data['marketingCompanies'] = MarketingCompanies::where('status', 1)->orderBy('order_id', 'desc')->get();
    	$data['marketingPersons'] = MarketingPersons::where('status', 1)->orderBy('order_id', 'desc')->get();

        # common controller #
    	$commonController = new CommonController;
    	$data['categories'] = $commonController->getCategories();
    	$data['divisions'] = $commonController->getDivisions();

    	return view('posts::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request){

    	$validator = Validator::make($request->all(), [
    		'news_type' => 'integer|required',
    		'home_status' => 'integer|nullable',
    		'parentCategory' => 'integer|required',
    		'hideCategory' => 'array|nullable',
    		'categories' => 'array|required',
    		'initial_types' => 'array|nullable',
    		'initials' => 'array|nullable',
    		'display_position' => 'string|between:0,50|nullable',
    		'shoulder' => 'string|between:0,500|nullable',
    		'headline2' => 'string|nullable',
    		'headline' => 'string|between:1,200|required',
    		'headline_color' => 'string|nullable',
    		'hanger' => 'string|between:0,500|nullable',
    		'reporter' => 'string|between:0,500|nullable',
    		'incident' => 'integer|nullable|exists:incidents,id',
    		'author_id' => 'array|nullable',
    		'topic' => 'array|nullable',
    		'body' => 'string|nullable',
    		'excerpt' => 'string|between:0,500|nullable',
            'description' => 'string|between:0,500|nullable',
    		'keywords' => 'string|between:0,1000|nullable',
    		'division' => 'integer|nullable|exists:locations,id',
    		'district' => 'integer|nullable|exists:locations,id',
    		'upazila' => 'integer|nullable|exists:locations,id',
    		'image.*' => 'image|nullable',
    		'image_caption.*' => 'string|between:0,2000|nullable',
    		'video_code' => 'string|between:0,6000|nullable',
    		'audio_code' => 'string|between:0,6000|nullable',
    		'filecaption.*' => 'string|between:0,1000|nullable',
    		'proved_id' => 'integer|nullable|exists:users,id',
    		'marketing_company_id' => 'integer|nullable|exists:marketing_companies,id',
    		'marketing_person_id' => 'integer|nullable|exists:marketing_persons,id',
    		'liveupdate_status' => 'integer|nullable',
    		'paidnews_status' => 'integer|nullable',
    		'hide_latest' => 'integer|nullable',
    		'show_updatetime' => 'integer|nullable',
    		'selected_status' => 'integer|nullable',
    		'selected2_status' => 'integer|nullable',
            'noindex' => 'integer|nullable',
            'exclude_xml' => 'integer|nullable',
            'custom_xml' => 'integer|nullable',
    	]);

    	if ($validator->fails()){
    		return redirect()->back()->withErrors($validator)->withInput();
    	}

    	try{
    		DB::beginTransaction();

    		$now = !empty($request->publish_date) ? $request->publish_date.' 00:00:00' : date('Y-m-d H:i:s');
    		$tableController = new TableController;
    		$tableController->createRequiredFolders($now);

            # article store #
    		$articleData = new Articles;
    		$articleData->category_id = $request->parentCategory;
    		$articleData->status = !empty($request->draft) && ($request->draft== 'draft') ? 0 : 1;
    		$articleData->headline = !empty($request->headline) ? preg_replace("/\xEF\xBB\xBF/", "", $request->headline) : Null;
    		$articleData->headline2 = !empty($request->headline2) ? preg_replace("/\xEF\xBB\xBF/", "", $request->headline2) : Null;
    		$articleData->shoulder = !empty($request->shoulder) ? preg_replace("/\xEF\xBB\xBF/", "", $request->shoulder) : Null;
    		$articleData->hanger = !empty($request->hanger) ? preg_replace("/\xEF\xBB\xBF/", "", $request->hanger) : Null;
    		$articleData->reporter = !empty($request->reporter) ? preg_replace("/\xEF\xBB\xBF/", "", $request->reporter) : Null;
    		$articleData->headline_color = !empty($request->headline_color) ? $request->headline_color : Null;
    		$articleData->incident_id = !empty($request->incident) ? $request->incident : Null;
    		$articleData->display_position = !empty($request->display_position) ? $request->display_position : Null;
    		$articleData->video_code = !empty($request->video_code) ? $request->video_code : Null;
    		$articleData->audio_code = !empty($request->audio_code) ? $request->audio_code : Null;
            $articleData->excerpt = !empty($request->excerpt) ? $request->excerpt : (!empty(strip_tags($request->body)) ? implode(' ', array_slice(explode(' ', strip_tags($request->body)), 0, 35)) : Null);
    		$articleData->description = !empty($request->description) ? $request->description : Null;
    		$articleData->keywords = !empty($request->keywords) ? $request->keywords : Null;
    		$articleData->tags = $articleData->keywords;
    		$articleData->division = isset($request->division) && ($request->division != 0) ? $request->division : Null;
    		$articleData->district = isset($request->district) && ($request->district != 0) ? $request->district : Null;
    		$articleData->upazila = isset($request->upazila) && ($request->upazila != 0) ? $request->upazila : Null;
    		$articleData->news_type = $request->news_type;
    		$articleData->proved_id = !empty($request->proved_id) ? $request->proved_id : Null;
    		$articleData->home_status = !empty($request->home_status) ? $request->home_status : 0;
    		$articleData->meta_sticker = !empty($request->meta_sticker) ? $request->meta_sticker : Null;
    		$articleData->created_by = Auth::user()->id;
    		$articleData->created_at = $now;
    		$articleData->order_id = $this->orderID();
    		$articleData->liveupdate_status = !empty($request->liveupdate_status) ? $request->liveupdate_status : Null;
    		$articleData->show_updatetime = !empty($request->show_updatetime) ? $request->show_updatetime : Null;
    		$articleData->marketing_company_id = !empty($request->marketing_company_id) ? $request->marketing_company_id : Null;
    		$articleData->marketing_person_id = !empty($request->marketing_person_id) ? $request->marketing_person_id : Null;
    		$articleData->paidnews_status = !empty($request->paidnews_status) ? $request->paidnews_status : Null;
    		$articleData->hide_latest = !empty($request->hide_latest) ? $request->hide_latest : Null;
    		$articleData->selected_status = !empty($request->selected_status) ? $request->selected_status : Null;
    		$articleData->selected2_status = !empty($request->selected2_status) ? $request->selected2_status : Null;
            $articleData->noindex = !empty($request->noindex) ? $request->noindex : Null;
            $articleData->exclude_xml = !empty($request->exclude_xml) ? $request->exclude_xml : Null;
            $articleData->custom_xml = !empty($request->custom_xml) ? $request->custom_xml : Null;
    		$articleData->save();
            # article store end #


            # display position
    		if(!empty($articleData->display_position)){
    			$articleIDs[] = $articleData->id;
    			$this->generateDisplayNews($articleIDs, $articleData->display_position);
    		}
            # display position


             # article authors store #
    		if(!empty($request->author_id) && (count($request->author_id)>0)){
    			foreach($request->author_id as $authorId){
    				$newsAuthor = new ArticleAuthors;
    				$newsAuthor->article_id = $articleData->id;
    				$newsAuthor->author_id = $authorId;
    				$newsAuthor->save(); 
    			}
    		}
            # articles authors store end #

            # article topics store #
    		if(!empty($request->topic) && (count($request->topic)>0)){
    			foreach($request->topic as $topicId){
    				$newsTopic = new ArticleTopics;
    				$newsTopic->article_id = $articleData->id;
    				$newsTopic->topic_id = $topicId;
    				$newsTopic->save(); 
    			}
    		}
            # articles topics store end #


            # article detail store #
    		if(!empty($articleData->id)){
    			$articleDetailData = new ArticleDetails;
    			$articleDetailData->article_id = $articleData->id;
    			$articleDetailData->body = !empty(strip_tags($request->body)) ? $request->body : Null;
    			$articleDetailData->save();
    		}
            # article detail store end #


            # article categories store #
    		if(!empty($request->categories) && (count($request->categories)>0)){
    			$hideCategories = $request->hideCategory;
    			foreach($request->categories as $categoryID){
    				$newsCategory = new ArticleCategories;
    				$newsCategory->category_id = $categoryID;
    				$newsCategory->article_id = $articleData->id;
    				$newsCategory->home_section_display = !empty($hideCategories) && array_search($categoryID, $hideCategories) !== false ? 0 : 1;
    				$newsCategory->save(); 
    			}
    		}
            # articles categories store end #

            # common controller #
    		$commonController = new CommonController;

            # new photos store #
    		$thumbnail = Null;
    		if(!is_null($request->file('image'))){
    			foreach($request->image as $key => $newImage){
    				if(!is_null($request->file('image')[$key])){
    					$image = $request->file('image')[$key];
    					$base_name = preg_replace('/\..+$/', '', $image->getClientOriginalName());
    					$base_name = explode(' ', $base_name);
    					$base_name = implode('-', $base_name);
    					$image_name = $base_name."-".uniqid().".".$image->getClientOriginalExtension();

    					$getSize = getimagesize($image);
    					$widthLarge = $key == 0 ? 1200 : $getSize[0];
    					$heightLarge = $key == 0 ? 675 : $getSize[1];
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

    					$resizedImagePathSocial = $commonController->compressAndResize($image, 'tempfiles/social/', $image_name, 80, 1200, 629);

                        # thumbnail and social thumbnail
    					$generatedSocialThumb = Null;
    					if($key == 0){
    						$thumbnail = $image_name;
    						$social_thumbnail = Null;
    						if(!empty($request->meta_sticker)){
    							$stickerInfo = FacebookStickers::where('id', $request->meta_sticker)->first();
    							if(!empty($stickerInfo)){
    								$sticker = env('UploadsLink').'uploads/fbstickers/'.$stickerInfo->sticker;
    								$generatedSocialThumb = $commonController->generateImageWithLogo($resizedImagePathSocial, $sticker, 'tempfiles/social-thumbnail/', $image_name);

    								$savingPath = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($now)).'social-thumbnail/';
    								Storage::disk(env('DISK'))->putFileAs($savingPath, $generatedSocialThumb, $image_name);
    								$social_thumbnail = $image_name;
    							}
    						}
    						DB::table('articles')->where('id', $articleData->id)->update(['thumbnail' => str_replace(".webp", ".jpg", $thumbnail), 'social_thumbnail' => str_replace(".webp", ".jpg", $social_thumbnail)]);
    					}

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
    					if(file_exists($resizedImagePathSocial)){ 
    						unlink($resizedImagePathSocial);
    					}


    					$photos = array(
    						'image'=> $image_name, 
    						'image_caption'=> !empty($request->image_caption[$key]) ? $request->image_caption[$key] : Null,
    						'article_id'=> $articleData->id, 
    						'status'=> $articleData->status,
    						'created_by'=> Auth::user()->id, 
    						'created_at'=> date("Y-m-d H:i:s"),
    					);
    					DB::table('article_photos')->insert($photos);
    				}
    			}
    		}
            # new photos store end #


            # new thumbnail2 store #
    		$thumbnail = Null;
    		if(!is_null($request->file('thumbnail2'))){
    			$image = $request->file('thumbnail2');
    			$base_name = preg_replace('/\..+$/', '', $image->getClientOriginalName());
    			$base_name = explode(' ', $base_name);
    			$base_name = implode('-', $base_name);
    			$image_name = time()."-".uniqid().".".$image->getClientOriginalExtension();
    			## upload thumbnail2
    			$resizedImagePathVThumb = $commonController->compressAndResize($image, 'tempfiles/', $image_name, 80, 1200, 675);
    			$savingPath = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($now));
    			Storage::disk(env('DISK'))->putFileAs($savingPath, $resizedImagePathVThumb, $image_name);
    			DB::table('articles')->where('id', $articleData->id)->update(['thumbnail2' => str_replace(".webp", ".jpg", $image_name)]);
    			# unlink temp files
    			if(file_exists($resizedImagePathVThumb)){ 
    				unlink($resizedImagePathVThumb);
    			}
    		}
            # new thumbnail2 store end #


            # article mis store #
    		if(!empty($request->initials) && (count($request->initials)>0)){
    			foreach($request->initials as $key => $initialID){
    				$newsMis = new ArticleMis;
    				$newsMis->employee_initial_id = $initialID;
    				$newsMis->employee_initial_type_id = $request->initial_types[$key];
    				$newsMis->article_id = $articleData->id;
    				$newsMis->article_date = $articleData->created_at;
    				$newsMis->created_by = Auth::user()->id;
    				$newsMis->created_at = date("Y-m-d H:i:s");
    				$newsMis->save(); 
    			}
    		}
            # articles mis store end #


            ## news hit count store
    		$savingPath = env('NewAssetFolderPath').'news_hit/'.date('Y/m/d/', strtotime($now)).$articleData->id.'.txt';
    		Storage::disk(env('DISK'))->put($savingPath, 0);
            ## news hit count store end

    		DB::commit();

            # redis regenrate
    		$cacheController = new CacheControllsController;
    		$cacheController->redisRegenerateNewsList($articleData->id);
    		$cacheController->redisGenerateLatestNews($articleData->id);
    		$cacheController->redisGenerateCategorySectionNews($request->categories);
    		if(!empty($request->display_position)){
    			$cacheController->redisGenerateDisplayedNews();
    		}
            # redis regenrate

            # server cache
    		$cacheController->clearServerUrlCache(env('WEBSITE'));
    		$cacheController->clearServerUrlCache(env('WEBSITE').'latest');
            # server cache

    		return redirect()->route('Posts')->with('success_message', 'A new article has been created.');

    	}catch(\Exception $e){
    		DB::rollback();
    		return redirect()->route('Posts')->with('error_message', 'The article has not been created. Error : '.$e->getMessage());
    	}

    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        # common controller #
    	$commonController = new CommonController;

    	$article = Articles::where('id', $id)->first();
    	$data['article'] = $article;

    	$data['categories'] = $commonController->getCategories();
    	if($article->news_type == 2){
    		$data['printCategories'] = $commonController->getCategoriesPrint();
    	}

        # article category info
    	$articleCategories = DB::table('article_categories')->select('category_id', 'home_section_display')->where('article_id', $id)->orderBy('id', 'asc')->get();
    	$articleCategoriesArray = Null;
    	$articleCategoriesHideSectionArray = Null;
    	if(!empty($articleCategories) && (count($articleCategories)>0)){
    		foreach ($articleCategories as $key => $articleCategory) {
    			$articleCategoriesArray[] = $articleCategory->category_id;
    			if($articleCategory->home_section_display == 0){
    				$articleCategoriesHideSectionArray[] = $articleCategory->category_id;
    			}
    		}
    	}
    	$data['articleCategories'] = $articleCategoriesArray;
    	$data['articleHideCategories'] = !empty($articleCategoriesHideSectionArray) ? implode(',', $articleCategoriesHideSectionArray) : '';
        # article category info

        # article author info
    	$articleAuthors = DB::table('article_authors')->select('author_id')->where('article_id', $id)->orderBy('id', 'asc')->get();
    	$articleAuthorsArray = Null;
    	if(!empty($articleAuthors) && (count($articleAuthors)>0)){
    		foreach ($articleAuthors as $key => $articleAuthor) {
    			$articleAuthorsArray[] = $articleAuthor->author_id;
    		}
    	}
    	$data['articleAuthors'] = $articleAuthorsArray;
        # article author info

        # article topic info
    	$articleTopics = DB::table('article_topics')->where('article_topics.article_id', $id)->leftjoin('archived_topics', 'archived_topics.id', '=', 'article_topics.topic_id')->select('archived_topics.id', 'archived_topics.topic_title')->orderBy('article_topics.id', 'asc')->get();
    	$articleTopicsArray = Null;
    	if(!empty($articleTopics) && (count($articleTopics)>0)){
    		foreach ($articleTopics as $key => $articleTopic) {
    			$articleTopicsArray[] = array('id' => $articleTopic->id, 'topic_title' => $articleTopic->topic_title);
    		}
    	}
    	$data['articleTopics'] = $articleTopicsArray;
        # article topic info

    	$data['employeeInitials'] = EmployeeInitials::where('status', 1)->orderBy('order_id', 'desc')->get();
    	$data['types'] = EmployeeInitialsType::where('status', 1)->orderBy('order_id', 'desc')->get();
    	$data['articleMis'] = DB::table('article_mis')->where('article_id', $id)->orderBy('id', 'asc')->get();

    	$data['photos'] = DB::table('article_photos')->where('article_id', $id)->get();
    	$data['detail'] = DB::table('article_details')->where('article_id', $id)->first();


        # editor info
    	if(!empty($article->editor_taken) && ($article->editor_taken != Auth::user()->id)){
    		$userInfo = User::where('id', $article->editor_taken)->first();
    		return redirect()->route('Posts')->with('editor_message', $userInfo->name.'<br>Working on this article. Please ask him/her to release this article.');
    	}else{
    		Articles::where('id', $article->id)->update(['editor_taken' => Auth::user()->id, 'editor_taken_at' => date('Y-m-d H:i:s')]);
    	}
        # end editor info

    	$data['incidents'] = DB::table('incidents')->where('status', 1)->orderBy('id', 'desc')->get();
    	$data['authors'] = DB::table('authors')->where('status', 1)->orderBy('order_id', 'desc')->get();
    	$data['metaStickers'] = FacebookStickers::where('status', 1)->orderBy('order_id', 'desc')->get();
    	$data['divisions'] = $commonController->getDivisions();
    	$data['marketingCompanies'] = MarketingCompanies::where('status', 1)->orderBy('order_id', 'desc')->get();
    	$data['marketingPersons'] = MarketingPersons::where('status', 1)->orderBy('order_id', 'desc')->get();

    	return view('posts::edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
    	$articleId = $request->articleId;

    	$validator = Validator::make($request->all(), [
    		'news_type' => 'integer|required',
    		'home_status' => 'integer|nullable',
    		'hideCategory' => 'array|nullable',
    		'parentCategory' => 'integer|required',
    		'categories' => 'array|required',
    		'initial_types' => 'array|nullable',
    		'initials' => 'array|nullable',
    		'display_position' => 'string|between:0,50|nullable',
    		'shoulder' => 'string|between:0,500|nullable',
    		'headline2' => 'string|between:0,200|nullable',
    		'headline' => 'string|between:1,200|required',
    		'headline_color' => 'string|nullable',
    		'hanger' => 'string|between:0,500|nullable',
    		'reporter' => 'string|between:0,500|nullable',
    		'author_id' => 'array|nullable',
    		'incident' => 'integer|nullable|exists:incidents,id',
    		'topic' => 'array|nullable',
    		'body' => 'string|nullable',
            'excerpt' => 'string|between:0,500|nullable',
    		'description' => 'string|between:0,500|nullable',
    		'keywords' => 'string|between:0,1000|nullable',
    		'division' => 'integer|nullable|exists:locations,id',
    		'district' => 'integer|nullable|exists:locations,id',
    		'upazila' => 'integer|nullable|exists:locations,id',
    		'image.*' => 'image|nullable',
    		'image_caption.*' => 'string|between:0,2000|nullable',
    		'video_code' => 'string|between:0,6000|nullable',
    		'audio_code' => 'string|between:0,6000|nullable',
    		'filecaption.*' => 'string|between:0,1000|nullable',
    		'proved_id' => 'integer|nullable|exists:users,id',
    		'marketing_company_id' => 'integer|nullable|exists:marketing_companies,id',
    		'marketing_person_id' => 'integer|nullable|exists:marketing_persons,id',
    		'liveupdate_status' => 'integer|nullable',
    		'paidnews_status' => 'integer|nullable',
    		'hide_latest' => 'integer|nullable',
    		'show_updatetime' => 'integer|nullable',
    		'selected_status' => 'integer|nullable',
    		'selected2_status' => 'integer|nullable',
            'noindex' => 'integer|nullable',
            'exclude_xml' => 'integer|nullable',
            'custom_xml' => 'integer|nullable',
    	]);

    	if ($validator->fails()){
    		return redirect()->back()->withErrors($validator)->withInput();
    	}

    	try{            
    		DB::beginTransaction();
    		$tableController = new TableController;
    		$tableController->createRequiredFolders($request->createDate);

            # article store #
    		$articleData = Articles::find($id);

            # display position
    		if($articleData->display_position != $request->display_position){
    			$articleIDs[] = $articleData->id;
    			$this->generateDisplayNews($articleIDs, $request->display_position);
    		}
            # display position

    		$display_position_old = $articleData->display_position;
    		$articleData->category_id = $request->parentCategory;
    		$articleData->status = !empty($request->draft) && ($request->draft== 'draft') ? 0 : 1;
    		$articleData->headline = !empty($request->headline) ? preg_replace("/\xEF\xBB\xBF/", "", $request->headline) : Null;
    		$articleData->headline2 = !empty($request->headline2) ? preg_replace("/\xEF\xBB\xBF/", "", $request->headline2) : Null;
    		$articleData->shoulder = !empty($request->shoulder) ? preg_replace("/\xEF\xBB\xBF/", "", $request->shoulder) : Null;
    		$articleData->hanger = !empty($request->hanger) ? preg_replace("/\xEF\xBB\xBF/", "", $request->hanger) : Null;
    		$articleData->reporter = !empty($request->reporter) ? preg_replace("/\xEF\xBB\xBF/", "", $request->reporter) : Null;
    		$articleData->headline_color = !empty($request->headline_color) ? $request->headline_color : Null;
    		$articleData->incident_id = !empty($request->incident) ? $request->incident : Null;
    		$articleData->display_position = !empty($request->display_position) ? $request->display_position : Null;
    		$articleData->video_code = !empty($request->video_code) ? $request->video_code : Null;
    		$articleData->audio_code = !empty($request->audio_code) ? $request->audio_code : Null;
            $articleData->excerpt = !empty($request->excerpt) ? $request->excerpt : (!empty(strip_tags($request->body)) ? implode(' ', array_slice(explode(' ', strip_tags($request->body)), 0, 35)) : Null);
    		$articleData->description = !empty($request->description) ? $request->description : Null;
    		$articleData->keywords = !empty($request->keywords) ? $request->keywords : Null;
    		$articleData->tags = $articleData->keywords;
    		$articleData->division = isset($request->division) && ($request->division != 0) ? $request->division : Null;
    		$articleData->district = isset($request->district) && ($request->district != 0) ? $request->district : Null;
    		$articleData->upazila = isset($request->upazila) && ($request->upazila != 0) ? $request->upazila : Null;
    		$articleData->news_type = $request->news_type;
    		$articleData->proved_id = !empty($request->proved_id) ? $request->proved_id : $articleData->proved_id;
    		$articleData->proved_id = !empty($request->not_proved) ? Null : $articleData->proved_id;
    		$articleData->home_status = !empty($request->home_status) ? $request->home_status : 0;
    		$articleData->meta_sticker = !empty($request->meta_sticker) ? $request->meta_sticker : Null;
    		$articleData->updated_by = Auth::user()->id;
    		$articleData->updated_at = date('Y-m-d H:i:s');
    		$articleData->liveupdate_status = !empty($request->liveupdate_status) ? $request->liveupdate_status : Null;
    		$articleData->show_updatetime = !empty($request->show_updatetime) ? $request->show_updatetime : Null;
    		$articleData->marketing_company_id = !empty($request->marketing_company_id) ? $request->marketing_company_id : Null;
    		$articleData->marketing_person_id = !empty($request->marketing_person_id) ? $request->marketing_person_id : Null;
    		$articleData->paidnews_status = !empty($request->paidnews_status) ? $request->paidnews_status : Null;
    		$articleData->hide_latest = !empty($request->hide_latest) ? $request->hide_latest : Null;
    		$articleData->selected_status = !empty($request->selected_status) ? $request->selected_status : Null;
    		$articleData->selected2_status = !empty($request->selected2_status) ? $request->selected2_status : Null;
            $articleData->noindex = !empty($request->noindex) ? $request->noindex : Null;
            $articleData->exclude_xml = !empty($request->exclude_xml) ? $request->exclude_xml : Null;
            $articleData->custom_xml = !empty($request->custom_xml) ? $request->custom_xml : Null;
    		$articleData->save();
            # article store end #


            # article author store #
    		$newsExistingAuthors = DB::table('article_authors')->where('article_id', $articleData->id)->select('author_id')->get()->toArray();
    		$newsExistingAuthorArray = Null;
    		if(!empty($newsExistingAuthors) && (count($newsExistingAuthors)>0)){
    			foreach ($newsExistingAuthors as $key => $newsExistingAuthor) {
    				$newsExistingAuthorArray[] = $newsExistingAuthor->author_id;
    			}
    		}

    		if(!empty($newsExistingAuthorArray)){
    			asort($newsExistingAuthorArray);
    			$newsExistingAuthorArray = implode('-', $newsExistingAuthorArray);
    		}

    		$newsNewAuthorArray = $request->author_id;
    		if(!empty($newsNewAuthorArray)){
    			asort($newsNewAuthorArray);
    			$newsNewAuthorArray = implode('-', $newsNewAuthorArray);
    		}
    		if($newsNewAuthorArray != $newsExistingAuthorArray){
    			DB::table('article_authors')->where('article_id', $articleData->id)->delete();
    			if(!empty($request->author_id) && (count($request->author_id)>0)){
    				foreach($request->author_id as $authorId){
    					$newAuthor[] = array(
    						'author_id' => $authorId,
    						'article_id' => $articleData->id,
    					);
    				}
    				DB::table('article_authors')->insert($newAuthor);
    			}
    		}
            # articles author store end #

            # article topic store #
    		$newsExistingTopics = DB::table('article_topics')->where('article_id', $articleData->id)->select('topic_id')->get()->toArray();
    		$newsExistingTopicArray = Null;
    		if(!empty($newsExistingTopics) && (count($newsExistingTopics)>0)){
    			foreach ($newsExistingTopics as $key => $newsExistingTopic) {
    				$newsExistingTopicArray[] = $newsExistingTopic->topic_id;
    			}
    		}

    		if(!empty($newsExistingTopicArray)){
    			asort($newsExistingTopicArray);
    			$newsExistingTopicArray = implode('-', $newsExistingTopicArray);
    		}

    		$newsNewTopicArray = $request->topic;
    		if(!empty($newsNewTopicArray)){
    			asort($newsNewTopicArray);
    			$newsNewTopicArray = implode('-', $newsNewTopicArray);
    		}
    		if($newsNewTopicArray != $newsExistingTopicArray){
    			DB::table('article_topics')->where('article_id', $articleData->id)->delete();
    			if(!empty($request->topic) && (count($request->topic)>0)){
    				foreach($request->topic as $topicId){
    					$newTopic[] = array(
    						'topic_id' => $topicId,
    						'article_id' => $articleData->id,
    					);
    				}
    				DB::table('article_topics')->insert($newTopic);
    			}
    		}
            # articles topic store end #


            # article detail store #
    		if(!empty($articleData->id)){
    			$articleDetailData = ArticleDetails::where('article_id', $articleData->id)->first();
    			if(!empty($articleDetailData)){
    				$articleDetailData->body = !empty(strip_tags($request->body)) ? $request->body : Null;
    			}else{
    				$articleDetailData = new ArticleDetails;
    				$articleDetailData->article_id = $articleData->id;
    				$articleDetailData->body = !empty(strip_tags($request->body)) ? $request->body : Null;
    			}
    			$articleDetailData->save();
    		}
            # article detail store end #


            # article categories store #
    		$newsExistingCategories = DB::table('article_categories')->where('article_id', $articleData->id)->select('category_id')->get()->toArray();
    		$newsExistingCategoryArray = Null;
    		if(!empty($newsExistingCategories) && (count($newsExistingCategories)>0)){
    			foreach ($newsExistingCategories as $key => $newsExistingCategory) {
    				$newsExistingCategoryArray[] = $newsExistingCategory->category_id;
    			}
    		}
    		$newsNewCategoryArray = $request->categories;
    		asort($newsExistingCategoryArray);
    		asort($newsNewCategoryArray);
    		$newsNewCategoryArray = implode('-', $newsNewCategoryArray);
    		$newsExistingCategoryArray = implode('-', $newsExistingCategoryArray);
    		if($newsNewCategoryArray != $newsExistingCategoryArray){
    			DB::table('article_categories')->where('article_id', $articleData->id)->delete();
    			if(!empty($request->categories) && (count($request->categories)>0)){
    				foreach($request->categories as $categoryID){
    					$newCategory[] = array(
    						'category_id' => $categoryID,
    						'article_id' => $articleData->id,
    					);
    				}
    				DB::table('article_categories')->insert($newCategory);
    			}
    		}

    		if(!empty($request->hideCategory) && count($request->hideCategory)>0){
    			foreach ($request->hideCategory as $key => $hideCategory) {
    				DB::table('article_categories')->where('article_id', $articleData->id)->where('category_id', $hideCategory)->update(['home_section_display' => 0]);
    			}
    		}else{
    			DB::table('article_categories')->where('article_id', $articleData->id)->update(['home_section_display' => 1]);
    		}
            # articles categories store end #

            # common controller #
    		$commonController = new CommonController;

    		$thumbnail = Null;
            # existing photos store #
    		if(!is_null($request->file('existingimage'))){
    			foreach($request->existingimage as $key => $existingimage){
    				if(!is_null($request->file('existingimage')[$key])){
    					$image = $request->file('existingimage')[$key];
    					$base_name = preg_replace('/\..+$/', '', $image->getClientOriginalName());
    					$base_name = explode(' ', $base_name);
    					$base_name = implode('-', $base_name);
    					$image_name = $base_name."-".uniqid().".".$image->getClientOriginalExtension();

    					$photoId = explode(',', $key);
    					$getSize = getimagesize($image);
    					$widthLarge = $photoId[0] == 0 ? 1200 : $getSize[0];
    					$heightLarge = $photoId[0] == 0 ? 675 : $getSize[1];
    					$widthMedium = $photoId[0] == 0 ? 400 : $getSize[0];
    					$heightMedium = $photoId[0] == 0 ? 224 : $getSize[1];
    					$widthSmall = $photoId[0] == 0 ? 200 : $getSize[0];
    					$heightSmall = $photoId[0] == 0 ? 112 : $getSize[1];


                        ## upload photos
    					$resizedImagePath = $commonController->compressAndResize($image, 'tempfiles/', $image_name, 80, $widthLarge, $heightLarge);
    					$savingPath = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($articleData->created_at));
    					Storage::disk(env('DISK'))->putFileAs($savingPath, $resizedImagePath, $image_name);

    					$resizedImagePathMedium = $commonController->compressAndResize($image, 'tempfiles/medium/', $image_name, 80, $widthMedium, $heightMedium);
    					$savingPathMedium = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($articleData->created_at)).'medium/';
    					Storage::disk(env('DISK'))->putFileAs($savingPathMedium, $resizedImagePathMedium, $image_name);

    					$resizedImagePathSmall = $commonController->compressAndResize($image, 'tempfiles/small/', $image_name, 80, $widthSmall, $heightSmall);
    					$savingPathSmall = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($articleData->created_at)).'small/';
    					Storage::disk(env('DISK'))->putFileAs($savingPathSmall, $resizedImagePathSmall, $image_name);

    					$resizedImagePathSocial = $commonController->compressAndResize($image, 'tempfiles/social/', $image_name, 80, 1200, 629);

                        # thumbnail and social thumbnail
    					$generatedSocialThumb = Null;
    					if($photoId[0] == 0){
    						$thumbnail = $image_name;
    						$social_thumbnail = Null;
    						if(!empty($request->meta_sticker)){
    							$stickerInfo = FacebookStickers::where('id', $request->meta_sticker)->first();
    							if(!empty($stickerInfo)){
    								$sticker = env('UploadsLink').'uploads/fbstickers/'.$stickerInfo->sticker;
    								$generatedSocialThumb = $commonController->generateImageWithLogo($resizedImagePathSocial, $sticker, 'tempfiles/social-thumbnail/', $image_name);

    								$savingPath = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($articleData->created_at)).'social-thumbnail/';
    								Storage::disk(env('DISK'))->putFileAs($savingPath, $generatedSocialThumb, $image_name);
    								$social_thumbnail = $image_name;
    							}
    						}
    						DB::table('articles')->where('id', $articleData->id)->update(['thumbnail' => str_replace(".webp", ".jpg", $thumbnail), 'social_thumbnail' => str_replace(".webp", ".jpg", $social_thumbnail)]);
    					}

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
    					if(file_exists($resizedImagePathSocial)){ 
    						unlink($resizedImagePathSocial);
    					}


    					if($photoId[0] == 0){
    						DB::table('articles')->where('id', $articleData->id)->update(['thumbnail' => $image_name]);
    					}

    					$photos = array(
    						'image'=> $image_name, 
    						'article_id'=> $articleData->id, 
    						'updated_by'=> Auth::user()->id, 
    						'updated_at'=> date("Y-m-d H:i:s"),
    					);
    					DB::table('article_photos')->where('id', $photoId[1])->update($photos);
    				}
    			}
    		}
            # existing photos store end #

            # existing photo captions store #
    		if(isset($request->existingimage_caption)){
    			foreach($request->existingimage_caption as $key => $existingimage_caption){
    				$photoId = explode(',', $key);
    				DB::table('article_photos')->where('id', $photoId[1])->update(['image_caption' => $existingimage_caption]); 
    			}
    		}
            # existing photo captions store end #


            # new photos store #
    		if(!is_null($request->file('image'))){
    			foreach($request->image as $key => $newImage){
    				if(!is_null($request->file('image')[$key])){
    					$image = $request->file('image')[$key];
    					$base_name = preg_replace('/\..+$/', '', $image->getClientOriginalName());
    					$base_name = explode(' ', $base_name);
    					$base_name = implode('-', $base_name);
    					$image_name = $base_name."-".uniqid().".".$image->getClientOriginalExtension();

    					$getSize = getimagesize($image);
    					$widthLarge = empty($thumbnail) && ($key == 0) ? 1200 : $getSize[0];
    					$heightLarge = empty($thumbnail) && ($key == 0) ? 675 : $getSize[1];
    					$widthMedium = empty($thumbnail) && ($key == 0) ? 400 : $getSize[0];
    					$heightMedium = empty($thumbnail) && ($key == 0) ? 224 : $getSize[1];
    					$widthSmall = empty($thumbnail) && ($key == 0) ? 200 : $getSize[0];
    					$heightSmall = empty($thumbnail) && ($key == 0) ? 112 : $getSize[1];

                        ## upload photos
    					$resizedImagePath = $commonController->compressAndResize($image, 'tempfiles/', $image_name, 80, $widthLarge, $heightLarge);
    					$savingPath = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($articleData->created_at));
    					Storage::disk(env('DISK'))->putFileAs($savingPath, $resizedImagePath, $image_name);

    					$resizedImagePathMedium = $commonController->compressAndResize($image, 'tempfiles/medium/', $image_name, 80, $widthMedium, $heightMedium);
    					$savingPathMedium = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($articleData->created_at)).'medium/';
    					Storage::disk(env('DISK'))->putFileAs($savingPathMedium, $resizedImagePathMedium, $image_name);

    					$resizedImagePathSmall = $commonController->compressAndResize($image, 'tempfiles/small/', $image_name, 80, $widthMedium, $heightMedium);
    					$savingPathSmall = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($articleData->created_at)).'small/';
    					Storage::disk(env('DISK'))->putFileAs($savingPathSmall, $resizedImagePathSmall, $image_name);

    					$resizedImagePathSocial = $commonController->compressAndResize($image, 'tempfiles/social/', $image_name, 80, 1200, 629);

                        # thumbnail and social thumbnail
    					$generatedSocialThumb = Null;
    					$photosCount = DB::table('article_photos')->where('article_id', $articleData->id)->count();
    					if($photosCount == 0 && ($key == 0)){
    						$thumbnail = $image_name;
    						$social_thumbnail = Null;
    						if(!empty($request->meta_sticker)){
    							$stickerInfo = FacebookStickers::where('id', $request->meta_sticker)->first();
    							if(!empty($stickerInfo)){
    								$sticker = env('UploadsLink').'uploads/fbstickers/'.$stickerInfo->sticker;
    								$generatedSocialThumb = $commonController->generateImageWithLogo($resizedImagePathSocial, $sticker, 'tempfiles/social-thumbnail/', $image_name);

    								$savingPath = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($articleData->created_at)).'social-thumbnail/';
    								Storage::disk(env('DISK'))->putFileAs($savingPath, $generatedSocialThumb, $image_name);
    								$social_thumbnail = $image_name;
    							}
    						}
    						DB::table('articles')->where('id', $articleData->id)->update(['thumbnail' => str_replace(".webp", ".jpg", $thumbnail), 'social_thumbnail' => str_replace(".webp", ".jpg", $social_thumbnail)]);
    					}

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
    					if(file_exists($resizedImagePathSocial)){ 
    						unlink($resizedImagePathSocial);
    					}

    					$photos = array(
    						'image'=> $image_name, 
    						'image_caption'=> !empty($request->image_caption[$key]) ? $request->image_caption[$key] : Null,
    						'article_id'=> $articleData->id, 
    						'status'=> $articleData->status,
    						'created_by'=> Auth::user()->id, 
    						'created_at'=> date("Y-m-d H:i:s"),
    					);
    					DB::table('article_photos')->insert($photos);
    				}
    			}
    		}
            # new photos store end #


            # new thumbnail2 store #
    		$thumbnail = Null;
    		if(!is_null($request->file('thumbnail2'))){
    			$image = $request->file('thumbnail2');
    			$base_name = preg_replace('/\..+$/', '', $image->getClientOriginalName());
    			$base_name = explode(' ', $base_name);
    			$base_name = implode('-', $base_name);
    			$image_name = time()."-".uniqid().".".$image->getClientOriginalExtension();
    			## upload thumbnail2
    			$resizedImagePathVThumb = $commonController->compressAndResize($image, 'tempfiles/', $image_name, 80, 1200, 675);
    			$savingPath = env('NewAssetFolderPath').'news_photos/'.date('Y/m/d/', strtotime($articleData->created_at));
    			Storage::disk(env('DISK'))->putFileAs($savingPath, $resizedImagePathVThumb, $image_name);
    			DB::table('articles')->where('id', $articleData->id)->update(['thumbnail2' => str_replace(".webp", ".jpg", $image_name)]);
    			# unlink temp files
    			if(file_exists($resizedImagePathVThumb)){ 
    				unlink($resizedImagePathVThumb);
    			}
    		}
            # new thumbnail2 store end #


            # article mis store #
    		ArticleMis::where('article_id', $articleData->id)->delete();
    		if(!empty($request->initials) && (count($request->initials)>0)){
    			foreach($request->initials as $key => $initialID){
    				$newsMis = new ArticleMis;
    				$newsMis->employee_initial_id = $initialID;
    				$newsMis->employee_initial_type_id = $request->initial_types[$key];
    				$newsMis->article_id = $articleData->id;
    				$newsMis->article_date = $articleData->created_at;
    				$newsMis->created_by = Auth::user()->id;
    				$newsMis->created_at = date("Y-m-d H:i:s");
    				$newsMis->save(); 
    			}
    		}
            # articles mis store end #


            # editor info
    		Articles::where('id', $articleData->id)->update(['editor_taken' => Null, 'editor_taken_at' => Null]);

    		DB::commit();

            # redis regenrate
    		$cacheController = new CacheControllsController;
    		$cacheController->redisRegenerateNewsList($articleData->id);
    		$cacheController->redisRegenerateLatestNews($articleData->id);
    		$cacheController->redisRegenerateCategorySectionNews($newsNewCategoryArray, $newsExistingCategoryArray);
    		if(!empty($display_position_old) || !empty($request->display_position)){
    			$cacheController->redisGenerateDisplayedNews();
    		}
            # redis regenrate

            # server cache
    		$cacheController->clearServerUrlCache(env('WEBSITE'));
    		$cacheController->clearServerUrlCache(env('WEBSITE').'latest');
    		if(!empty($articleData->parentCategory)){
    			$cacheController->clearServerUrlCache(env('WEBSITE').$articleData->parentCategory->title.'/'.$articleData->id);
    		}
            # server cache

    		$redirectTo = !empty($request->redirect) ? $request->redirect : url('posts');
    		return redirect()->to($redirectTo)->with('success_message', 'The article has been updated.');

    	}catch(\Exception $e){
    		DB::rollback();
    		// dd($e);
    		return redirect()->to($redirectTo)->with('error_message', 'The article has not been updated. Error  : '.$e->getMessage());
    	}
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
    				$dataInfo = Articles::find($id);
    				$dataInfo->order_id = $order_id;
    				$dataInfo->updated_by = Auth::user()->id;
    				$dataInfo->updated_at = date('Y-m-d H:i:s');
    				$dataInfo->save();
    				$count++;
    			}
    		}

    		if($request->bulkStatus == "swapOrderLeadTop"){
    			foreach($request->ids as $key => $articleIds){
    				$id = explode(",", $articleIds);
    				DB::table('articles')->where('id', $id[0])->update(['display_order_id' => $key+1]);
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

                // foreach($request->ids as $articleIds){
                //  $id = explode(",", $articleIds);
                //  $article = DB::table('articles')->where('id', $id[0])->update(['display_position' => $request->bulkStatus]);
                // }
    		}

    		elseif($request->bulkStatus == "top"){
    			$selectedIds = Null;
    			foreach($request->ids as $key => $articleID){
    				$id = explode(",", $articleID);
    				$selectedIds[] = $id[0];
    			}
    			$articleIDs = $selectedIds;
    			$this->generateDisplayNews($articleIDs, 'top');

                // foreach($request->ids as $articleIds){
                //     $id = explode(",", $articleIds);
                //     $article = DB::table('articles')->where('id', $id[0])->update(['display_position' => $request->bulkStatus]);
                // }
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

    		elseif($request->bulkStatus == "Selected"){
    			foreach($request->ids as $articleIds){
    				$id = explode(",", $articleIds);
    				$article = DB::table('articles')->where('id', $id[0])->update(['selected_status' => 1]);
    			}
    		}

    		elseif($request->bulkStatus == "remove_Selected"){
    			foreach($request->ids as $articleIds){
    				$id = explode(",", $articleIds);
    				$article = DB::table('articles')->where('id', $id[0])->update(['selected_status' => Null]);
    			}
    		}

    		elseif($request->bulkStatus == "Selected2"){
    			foreach($request->ids as $articleIds){
    				$id = explode(",", $articleIds);
    				$article = DB::table('articles')->where('id', $id[0])->update(['selected2_status' => 1]);
    			}
    		}

    		elseif($request->bulkStatus == "remove_Selected2"){
    			foreach($request->ids as $articleIds){
    				$id = explode(",", $articleIds);
    				$article = DB::table('articles')->where('id', $id[0])->update(['selected2_status' => Null]);
    			}
    		}

    		elseif($request->bulkStatus == "markPaid"){
    			foreach($request->ids as $articleIds){
    				$id = explode(",", $articleIds);
    				$article = DB::table('articles')->where('id', $id[0])->update(['paidnews_status' => 1]);
    			}
    		}

    		elseif($request->bulkStatus == "removePaid"){
    			foreach($request->ids as $articleIds){
    				$id = explode(",", $articleIds);
    				$article = DB::table('articles')->where('id', $id[0])->update(['paidnews_status' => Null]);
    			}
    		}


            # redis regenrate
    		$cacheController = new CacheControllsController;
    		$cacheController->redisGenerateDisplayedNews();
            # redis regenrate

            # server cache
    		$cacheController->clearServerUrlCache(env('WEBSITE'));
    		$cacheController->clearServerUrlCache(env('WEBSITE').'latest');
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
    			$showTop = !empty(env('topnews')) ? env('topnews')+3 : 10;
    			$selectedIds = $articleIDs[0];
    			$displayedArticles = DB::table('articles')->orderBy('articles.display_position', 'asc')->orderBy('articles.display_order_id', 'asc')->where('articles.id', '!=', $selectedIds)->whereIn('articles.display_position', ['lead', 'top'])->get();

    			if(!empty($selectedIds)){
    				$order++;
    				DB::table('articles')->where('id', $selectedIds)->update(['display_position' => 'lead', 'display_order_id' => $order]);
    			}
    			if(!empty($displayedArticles)){
    				foreach($displayedArticles as $key => $displayedArticle){
    					$order++;
    					if($order <= $showTop){
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
    			$showTop = !empty(env('topnews')) ? env('topnews')+3 : 10;
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
    					if($order <= $showTop){
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



    public function orderID(){
    	$orderIDInfo = Articles::select('articles.order_id')->orderBy('order_id', 'desc')->first();
    	if(!empty($orderIDInfo)){
    		$orderID = $orderIDInfo->order_id+1;
    	}else{
    		$orderID = 1;
    	}
    	return $orderID;
    }


    public function getArticles($postType = Null){
    	$paginationAmount = isset($_GET['paginationAmount']) && !empty($_GET['paginationAmount']) ? $_GET['paginationAmount'] : 10;

    	$articles = Articles::select('articles.*')->where('articles.status', '!=', 2)
    	->when(!empty($postType) && ($postType == 'selected'), function ($query) {
    		$query->where('articles.selected_status', 1);
    		$query->orWhere('articles.selected2_status', 1);
    	})
    	->when(!empty($postType) && ($postType == 'paid'), function ($query) {
    		$query->where('articles.paidnews_status', 1);
    	})
    	->when(!empty($postType) && ($postType == 'draft'), function ($query) {
    		$query->where('articles.status', 0);
    	})
    	->when(!empty($postType) && ($postType == 'my-post'), function ($query) {
    		$query->where('articles.created_by', Auth::user()->id);
    	})
    	->when(!empty($postType) && ($postType == 'audios'), function ($query) {
    		$query->whereNotNull('articles.audio_code');
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
        ->when(isset($_GET['custom_xml']) && !empty($_GET['custom_xml']), function ($query) {
            $query->where('articles.custom_xml', $_GET['custom_xml']);
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
    	->when(!empty($postType) && ($postType == 'photos' || $postType == 'videos'), function ($query) use ($postType) {
    		$query->leftJoin('article_categories', 'article_categories.article_id', '=', 'articles.id')->leftJoin('categories', 'categories.id', '=', 'article_categories.category_id')->where('categories.title', $postType);
    	})
    	->when(!empty($postType) && ($postType == 'leadtop'), function ($query) {
    		$query->whereNotNull('articles.display_position')->orderBy('articles.display_position', 'asc')->orderBy('articles.display_order_id', 'asc');
    	})
    	->when(($postType != 'leadtop'), function ($query) {
    		$query->where('articles.news_type', 1)->orderBy('articles.order_id', 'desc');
    	})

    	->simplePaginate($paginationAmount);     
    	return $articles;
    }


}
