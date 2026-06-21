<?php

namespace Modules\Events\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Modules\CacheControlls\Http\Controllers\CacheControllsController;
use App\Http\Controllers\CommonController;
use DB;
use Auth;
use Session;
use Validator;
use App\Models\Events;
use App\Models\Categories;
use App\Models\Articles;
use App\Models\ArchivedTopics;

class EventsController extends Controller
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

    	$data['lists'] = Events::whereIn('status', [1,2])
    	->when(isset($_GET['title']) && !empty($_GET['title']), function ($query) {
    		$query->where('title', 'like', '%'.$_GET['title'].'%');
    	})
    	->when(isset($_GET['topic_id']) && !empty($_GET['topic_id']), function ($query) {
    		$query->where('topic_id', 'like', '%'.$_GET['topic_id'].'%');
    	})
    	->orderBy('order_id', 'desc')->simplePaginate($paginationAmount);

    	return view('events::index', $data);
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
    		'slug' => 'required|string',
    		'topic_id' => 'required|numeric',
    		'small_banner' => 'nullable|image',
    		'large_banner' => 'nullable|image',
    		'no_of_article' => 'required|numeric',
    		'type' => 'required|numeric|between:1,3',
    		'status' => 'numeric|between:-1,2',
    	]);

    	if ($validator->fails()) {
    		return redirect()->route('Events')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
    	}

    	try{
    		DB::beginTransaction();

    		$dataInfo = new Events;
    		$dataInfo->title = $request->title;
    		$dataInfo->slug = $request->slug;
    		$dataInfo->topic_id = $request->topic_id;
    		$dataInfo->no_of_article = $request->no_of_article;
    		$dataInfo->type = $request->type;
    		$dataInfo->order_id = $this->orderID();
    		$dataInfo->status = !empty($request->status) ? $request->status : -1;
    		$dataInfo->created_by = Auth::user()->id;
    		$dataInfo->created_at = date('Y-m-d H:i:s');

    		if(!empty($request->small_banner)){
    			if(!is_null($request->file('small_banner'))){
    				$image = $request->file('small_banner');
    				$fileName = time().'-'.uniqid().".".$image->getClientOriginalExtension();
    				$savingPath = env('UploadsFolderPath').'events/';
    				Storage::disk(env('DISK'))->putFileAs($savingPath, $image, $fileName);
    				$dataInfo->small_banner = $fileName;
    			}
    		}

    		if(!empty($request->large_banner)){
    			if(!is_null($request->file('large_banner'))){
    				$image = $request->file('large_banner');
    				$fileName = time().'-'.uniqid().".".$image->getClientOriginalExtension();
    				$savingPath = env('UploadsFolderPath').'events/';
    				Storage::disk(env('DISK'))->putFileAs($savingPath, $image, $fileName);
    				$dataInfo->large_banner = $fileName;
    			}
    		}

    		$dataInfo->save();

    		DB::commit();

         	# redis regenrate
    		$cacheController = new CacheControllsController;
    		$cacheController->redisGenerateEventInfo();
         	# redis regenrate

    		return redirect()->route('Events')->with('success_message', 'Event has been created successfully!.');

    	}catch(Exception $e){
    		DB::rollback();
    		return redirect()->route('Events')->with('error_message', 'Failed to create Event!.');
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
    		'slug' => 'required|string',
    		'topic_id' => 'required|numeric',
    		'small_banner' => 'nullable|image',
    		'large_banner' => 'nullable|image',
    		'no_of_article' => 'required|numeric',
    		'type' => 'required|numeric|between:1,3',
    		'status' => 'numeric|between:-1,2',
    		'id' => 'required|numeric',
    	]);

    	if ($validator->fails()) {
    		return redirect()->route('Events')->withErrors($validator)->withInput()->with('error_message','Form validation failed!.');
    	}

    	try{
    		DB::beginTransaction();

    		$dataInfo = Events::find($request->id);
    		$dataInfo->title = $request->title;
    		$dataInfo->slug = $request->slug;
    		$dataInfo->topic_id = $request->topic_id;
    		$dataInfo->no_of_article = $request->no_of_article;
    		$dataInfo->type = $request->type;
    		$dataInfo->status = !empty($request->status) ? $request->status : -1;
    		$dataInfo->updated_by = Auth::user()->id;
    		$dataInfo->updated_at = date('Y-m-d H:i:s');

    		if(!empty($request->small_banner)){
    			if(!is_null($request->file('small_banner'))){
    				$image = $request->file('small_banner');
    				$fileName = time().'-'.uniqid().".".$image->getClientOriginalExtension();
    				$savingPath = env('UploadsFolderPath').'events/';
    				Storage::disk(env('DISK'))->putFileAs($savingPath, $image, $fileName);
    				$dataInfo->small_banner = $fileName;
    			}
    		}

    		if(!empty($request->large_banner)){
    			if(!is_null($request->file('large_banner'))){
    				$image = $request->file('large_banner');
    				$fileName = time().'-'.uniqid().".".$image->getClientOriginalExtension();
    				$savingPath = env('UploadsFolderPath').'events/';
    				Storage::disk(env('DISK'))->putFileAs($savingPath, $image, $fileName);
    				$dataInfo->large_banner = $fileName;
    			}
    		}

    		$dataInfo->save();

    		DB::commit();

         	# redis regenrate
    		$cacheController = new CacheControllsController;
    		$cacheController->redisGenerateEventInfo();
         	# redis regenrate

    		return redirect()->route('Events')->with('success_message', 'Event has been updated successfully!.');

    	}catch(Exception $e){
    		DB::rollback();
    		return redirect()->route('Events')->with('error_message', 'Failed to update Event!.');
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
    		$dataInfo = Events::find($id);
    		$dataInfo->status = -1;
    		$dataInfo->updated_by = Auth::user()->id;
    		$dataInfo->updated_at = date('Y-m-d H:i:s');
    		$dataInfo->save();

            # redis regenrate
    		$cacheController = new CacheControllsController;
    		$cacheController->redisGenerateEventInfo();
            # redis regenrate

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
    				$dataInfo = Events::find($id);
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
    				$dataInfo = Events::find($id);
    				$dataInfo->status = $request->bulkStatus;
    				$dataInfo->updated_by = Auth::user()->id;
    				$dataInfo->updated_at = date('Y-m-d H:i:s');
    				$dataInfo->save();
    			}
    		}

        	# redis regenrate
    		$cacheController = new CacheControllsController;
    		$cacheController->redisGenerateEventInfo();
        	# redis regenrate

    		return redirect()->back()->with('success_message', 'Success! Action Applied Successfully.');
    	}
    	return redirect()->back()->with('error_message', 'Alert! Error Applying Action.');
    }


    public function orderID(){
    	$orderIDInfo = Events::orderBy('order_id', 'desc')->first();
    	if(!empty($orderIDInfo)){
    		$orderID = $orderIDInfo->order_id+1;
    	}else{
    		$orderID = 1;
    	}
    	return $orderID;
    }


    public function getSlug($title){
    	$urlTitle = str_replace(" ", "-", preg_replace('/([%\$!-_;:,.#\'"@*]+)/','', trim(strip_tags($title))));
    	$urlTitle = str_replace("‘", "", $urlTitle);
    	$urlTitle = str_replace("’", "", $urlTitle);
    	$urlTitle = str_replace("---", "-", $urlTitle);
    	$urlTitle = str_replace("--", "-", $urlTitle);
    	$bom = pack('H*','EFBBBF');
    	$urlTitle = preg_replace("/^$bom/", '', $urlTitle);
    	return $urlTitle;
    }

    public function eventNews($id) {
    	$data['eventInfo'] = Events::where('id', $id)->first();
    	if(!empty($data['eventInfo'])){
    		$data['articles'] = $this->getEventTagArticles($data['eventInfo']->topic_id);
    	}

        # common controller #
        $commonController = new CommonController;
        $data['categories'] = $commonController->getCategories();
    	return view('events::news', $data);
    }


    public function getEventTagArticles($topic_id){
    	$paginationAmount = isset($_GET['paginationAmount']) && !empty($_GET['paginationAmount']) ? $_GET['paginationAmount'] : 10;

    	$articles = Articles::select('articles.*')
        ->leftjoin('article_topics', 'article_topics.article_id', '=', 'articles.id')->where('article_topics.topic_id', $topic_id)

    	->when(isset($_GET['headline']) && !empty($_GET['headline']), function ($query) {
    		$query->where('articles.headline', 'like', '%'.$_GET['headline'].'%');
    	})
    	->when(isset($_GET['category']) && !empty($_GET['category']), function ($query) {
    		$query->leftjoin('article_categories', 'article_categories.article_id', '=', 'articles.id')->where('article_categories.category_id', $_GET['category']);
    	})
    	->orderBy(DB::raw('FIELD(articles.event_display_position, "eventLead")') , 'desc')->where('articles.status', '!=', 2)->orderBy('articles.order_id', 'desc')->simplePaginate($paginationAmount);

    	return $articles;
    }


    public function eventNewsBulkUpdate(Request $request)
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

            elseif($request->bulkStatus == 'releaseArticle'){
                foreach($request->ids as $id){
                    $explode = explode(',', $id);
                    $id = $explode[0];
                    $dataInfo = Articles::find($id);
                    $dataInfo->editor_taken = Null;
                    $dataInfo->editor_taken_at = Null;
                    $dataInfo->save();
                }
            }

            elseif($request->bulkStatus == 'eventLead'){
                foreach($request->ids as $id){
                    $explode = explode(',', $id);
                    $id = $explode[0];
                    $dataInfo = Articles::find($id);
                    $dataInfo->event_display_position = 'eventLead';
                    $dataInfo->updated_by = Auth::user()->id;
                    $dataInfo->updated_at = date('Y-m-d H:i:s');
                    $dataInfo->save();
                }
            }

            elseif($request->bulkStatus == 'eventLeadNo'){
                foreach($request->ids as $id){
                    $explode = explode(',', $id);
                    $id = $explode[0];
                    $dataInfo = Articles::find($id);
                    $dataInfo->event_display_position = Null;
                    $dataInfo->updated_by = Auth::user()->id;
                    $dataInfo->updated_at = date('Y-m-d H:i:s');
                    $dataInfo->save();
                }
            }

            # redis regenrate
            $cacheController = new CacheControllsController;
            $cacheController->redisGenerateEventInfo();
            # redis regenrate

            return redirect()->back()->with('success_message', 'Success! Action Applied Successfully.');
        }
        return redirect()->back()->with('error_message', 'Alert! Error Applying Action.');
    }


}
