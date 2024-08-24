<?php

namespace App\Http\Controllers\frontend;

use App\Models\News;
use App\Models\NewsInfo;
use App\Models\Category;
use App\Models\NewsDetails;
use App\Models\Reporter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsFEController extends Controller
{
    public function news($slug)
    {
        $array = explode('-', $slug);
        $id = end($array);
        $select = ['NewsSummary','NewsTitle', 'id', 'HomepageTitle', 'NewsCategoryID', 'Thumbimage', 'MediumImage', 'TileUrl', 'CategoryName', 'CategoryBngName', 'ImageTag', 'Date'];
        $select2 = ['id', 'NewsTitle', 'TileUrl', 'CategoryName'];
        $select3 = ['id', 'HomepageTitle', 'NewsCategoryID', 'Thumbimage', 'TileUrl', 'CategoryName', 'CategoryBngName'];

        $data['detailnews'] = News::where('id', $id)->where('IsActive', 1)->first();
    
        if (!$data['detailnews']) return redirect()->route('home.index');
    
        $data['detailnews'] = $data['detailnews']->toArray();
        $data['newsnext'] = optional(News::where('id', '>', $id)->where('IsActive', 1)->select($select)->first())->toArray() ?? [];
        $data['newsprev'] = optional(News::where('id', '<', $id)->where('IsActive', 1)->select($select)->first())->toArray() ?? [];
        $data['reporterinfo'] = optional(Reporter::where('ReporterName', $data['detailnews']["ReporterName"])->first())->toArray() ?? [];
        $data['newsdescription'] = NewsDetails::where('NewsID', $id)->value('Detail');
        $data['latestNews'] = optional(News::select($select3)->where('IsActive', 1)->where('IsRecent', 1)->orderByDesc('id')->limit(6)->get())->toArray() ?? [];
        $topNewsIds = NewsInfo::whereDate('Date', '>=', date('Y-m-d'))->where('VisitNumber', '>', 0)->orderBy('VisitNumber', 'DESC')->limit(6)->pluck('NewsID')->toArray();
        $data['topread'] = optional(News::select($select3)->where('IsActive', 1)->whereIn('id', $topNewsIds)->orderByDesc('id')->limit(6)->get())->toArray() ?? [];
       
        $data['title'] = $data['detailnews']['ShareTitle'];
        $data['description'] = $data['detailnews']['NewsSummary'];
        $newscategoryid = $data['detailnews']["NewsCategoryID"];
        $data['othernews'] = News::where('id', '!=', $id)->where('IsActive', 1)->orderByDesc('id')->select($select)->limit(8)->get()->toArray();
        $data['realtednews'] = [];
        if (isset($data['detailnews']["RelatedNews"]) && !empty($data['detailnews']["RelatedNews"])) {
            $myArray = explode(',', $data['detailnews']["RelatedNews"]);
            $data['realtednews'] = News::whereIn('id', $myArray)->where('IsActive', 1)->orderByDesc('id')->select($select2)->limit(8)->get()->toArray();
        }
        return view('frontend.news', compact('data'));
    }
    public function comment(Request $request)
    {
        NewsInfo::where('NewsID',$request->article_id)->increment('CommentNumber');
        return response()->json(['success' => true,'message' => 'Comment number updated successfully.',]);
    }
    public function visitnum(Request $request)
    {
        NewsInfo::where('NewsID', $request->news_id)->increment('VisitNumber');
        return response()->json([
            'success' => true,
            'message' => 'Visit number updated successfully.',
        ]);
    }
    public function newsprint($id)
	{
	  	$data['task'] = NewsDetails::where(['NewsID' =>$id])->first();
	    $data['newsdata'] = News::find($id);
        return view('frontend.news-print', compact('data'));
	}

    
}
