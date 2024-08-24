<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\BasicInfo;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;

class ArchiveFEController extends Controller
{
    public function index(Request $request, $date = null)
    {
        $date = $request->date;
        if(isset($request->Year)){
            $mkDate = $request->Year.'-'.$request->Month .'-'.$request->Day;
            return redirect()->route("archives.index",$mkDate);
        }
        $data["selecteddate"] =  $date!=0 ? $date : date("d F, Y");
        $date =  $date!=null ? $date : '2017-10-06';
        $data['newslist'] =  News::select('id','HomepageTitle','NewsCategoryID','TileUrl','CategoryName','CategoryBngName','Date','ParentCategoryID')->where(['IsActive'=>1, 'IsRecent'=>1])->whereDate('Date',$date)->orderByDesc('id')->get()->toArray();
        $data['categorylist'] =  Category::select('id as ID', 'Caption as Name')->where('id','!=',1)->where('ParentID',0)->orderBy('Priority')->limit(100)->get()->toArray();
        $data['categorylistchild'] =  Category::select('id as ID','Caption as Name','ParentID')->where('ParentID','>',0)->orderBy('Priority')->limit(300)->get()->toArray();
        return view('frontend.archive', compact('data'));
    }
}
