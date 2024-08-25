<?php

namespace App\Http\Controllers\frontend;

use App\Models\News;
use App\Models\Poll;
use App\Models\Gallery;
use App\Models\Category;
use App\Models\NewsInfo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use DB;

class HomeController extends Controller
{
    public function index()
    {
        // $start = microtime(true); 
        // $end = microtime(true);$executionTime = $end - $start;echo "Query Execution Time: {$executionTime} seconds";die();

        $data['topread'] = [];
        $data['topcomment'] = [];
        $statusCon = ['IsActive' => 1];
        $catDetails = ['bangladesh' => 4,'world' => 7,'economy' => 14,'opinion' => 65,'tech' => 67,'sports' => 12,'entertainment' => 39,'life' => 15];
        $catLimit = ['bangladesh' => 5,'world' => 5,'economy' => 5,'opinion' => 1,'tech' => 5,'sports' => 3,'entertainment' => 4,'life' => 5];
        $select0 = ['id','NewsSummary', 'HomepageTitle', 'NewsCategoryID', 'Thumbimage', 'MediumImage', 'TileUrl', 'CategoryName', 'CategoryBngName', 'ImageTag', 'Date'];
        $select1 = ['id', 'HomepageTitle', 'NewsCategoryID', 'Thumbimage', 'TileUrl', 'CategoryName', 'CategoryBngName'];
            
        $data['breaking'] = News::where($statusCon)->where('IsBreaking', 1)->where('BreakingTime', '>=', date('Y-m-d h:i:s'))->select(['id', 'HomepageTitle', 'NewsTitle', 'TileUrl', 'CategoryName'])->take(5)->get()->toArray();
        $data['leadNews'] = News::where($statusCon)->select('id', 'HomepageTitle', 'NewsSummary', 'NewsCategoryID', 'Thumbimage', 'MediumImage', 'TileUrl', 'CategoryName', 'CategoryBngName', 'ImageTag', 'Date', 'NewsHanger', 'NewsShoulder')->where('IsTop', 1)->orderByDesc("id")->take(5)->get()->toArray();//->orderByRaw("Priority asc, id desc")->orderByDesc("id")
        $data['editorchoice'] = News::where($statusCon)->select('id', 'HomepageTitle', 'NewsSummary', 'NewsCategoryID', 'Thumbimage', 'MediumImage', 'TileUrl', 'CategoryName', 'CategoryBngName', 'ImageTag', 'Date')->where('IsEditorChoice', 1)->orderByDesc('id')->limit(3)->get()->toArray();//->orderBy('EditorChoicePriority', 'asc')
        $data['selected'] = News::where($statusCon)->select('id', 'HomepageTitle', 'NewsCategoryID', 'Thumbimage', 'MediumImage', 'TileUrl', 'CategoryName', 'CategoryBngName', 'ImageTag', 'Date')->where('IsSeleted', 1)->orderByDesc('id')->limit(12)->get()->toArray();//->orderByRaw('SelectedPriority asc,id desc')
        $data['recent'] = News::where($statusCon)->select('id', 'HomepageTitle', 'NewsCategoryID', 'NewsSummary', 'Thumbimage', 'MediumImage', 'TileUrl', 'CategoryName', 'CategoryBngName', 'ImageTag', 'Date')->where('IsRecent', 1)->orderByDesc('id')->limit(6)->get()->toArray();
        $data['onlinepoll'] = Poll::where($statusCon)->where('IsClosed', 'No')->orderByDesc('id')->first()->toArray();
        $data['galleryphoto'] = Gallery::where($statusCon)->where('GalleryType', 1)->orderByDesc('id')->first()->toArray();
        $data['gallerysubcategory'] = Category::where($statusCon)->where('ParentID', 30)->orderBy('Priority', 'asc')->take(6)->get()->toArray();
    
        foreach ($catDetails as $key => $catID){
            $parentId = Category::find($catID)->ParentID;
            $priority = ($parentId == 0) ? "CategoryPriority asc, id desc" : "SubCategoryPriority asc, id desc";
            $catField = ($parentId == 0) ? "ParentCategoryID" : "SubCategoryID";
            $data[$key] = News::select($select0)->where($statusCon)->where($catField,$catID)->orderByDesc('id')->limit($catLimit[$key])->get()->toArray();//orderByRaw($priority)
        }
        $startDate = Carbon::today()->startOfDay();
        $NewsID = NewsInfo::where('Date', '>=', $startDate)->where('VisitNumber', '>', 0)->orderBy('VisitNumber', 'desc')->take(6)->pluck('NewsID')->toArray();
        if(count($NewsID)>0) $data['topread'] = News::select($select1)->where($statusCon)->whereIn('id', $NewsID)->orderByDesc('id')->take(6)->get()->toArray();
        $NewsID = Newsinfo::where('Date','>=',$startDate)->where('CommentNumber', '>', 0)->orderBy('CommentNumber', 'desc')->take(6)->pluck('NewsID')->toArray();
        if(count($NewsID)>0) $data['topcomment'] =  News::select($select1)->where($statusCon)->whereIn('id', $NewsID)->orderByDesc('id')->take(6)->get()->toArray();

        return view('frontend.index',compact('data'));
    }
    
}