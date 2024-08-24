<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\BasicInfo;
use App\Models\Category;
use App\Models\News;

class CategoryFEController extends Controller
{
    public function categories($link, $id)
    {
        $data['newslist'] = News::query()->where('IsActive',1);
        $data['childcatagory'] = Category::query();
        $select = ['id', 'NewsSummary', 'HomepageTitle', 'NewsCategoryID', 'Thumbimage', 'MediumImage', 'TileUrl', 'CategoryName', 'CategoryBngName', 'ImageTag', 'Date'];
        $data['category'] = Category::find($id)->toArray();
        if ($data['category']["ParentID"] == 0) {
            $data['childcatagory'] = $data['childcatagory']->where(['ParentID' => $data['category']["id"]])->orderBy('Priority', 'asc');
            $data['parentcategoryname'] = $data['category']['Caption'];
            $data['parentcategoryid'] = $data['category']['id'];

        } else {
            $data['childcatagory'] = $data['childcatagory']->where(['ParentID' => $data['category']["ParentID"]])->orderBy('Priority', 'desc');
            $tempcat = Category::select('id', 'Caption')->find($data['category']["ParentID"])->toArray();
            $data['parentcategoryname'] = $tempcat['Caption'];
            $data['parentcategoryid'] = $tempcat['id'];
        }
        $data['childcatagory'] = $data['childcatagory']->select(['Caption', 'SEOCaption', 'id'])->limit(10)->get()->toArray();
        if (count($data['childcatagory']) == 0 || $data['category']["ParentID"] != 0) {
            $data['siteinfo'] = BasicInfo::first()->toArray();
            $data['title'] = $data['category']['Caption'] . ' : ' . $data['siteinfo']["SiteName"];
            $data['description'] = $data['category']['Caption'] . ' : ' . $data['siteinfo']["SiteName"];
            if ($data['category']["ParentID"] != 1) {
                $category = ($data['category']["ParentID"] == 0) ? "ParentCategoryID" : "SubCategoryID";
                $col1 = $data['category']["ParentID"] == 0 ? 'CategoryPriority' : 'SubCategoryPriority';
                $data['newslist'] = $data['newslist']->where($category,$id)->orderBy($col1,'asc');
            } else {
                $data['newslist'] = $data['newslist']->where('TodaysCategory',$id);
            }

        } else {

            if ($data['category']["id"] != 1) {
                $category = $data['category']["ParentID"] == 0 ? "ParentCategoryID" : "SubCategoryID";
                $colName = $data['category']["ParentID"] == 0 ? 'CategoryPriority' : 'SubCategoryPriority';
                $data['newslist'] = $data['newslist']->where($category, $id)->orderBy($colName, 'asc');

                if (isset($data['childcatagory'][0]['id'])) {
                    $data['newslist1'] = News::where(['IsActive' => 1, 'SubCategoryID' => $data['childcatagory'][0]['id']])->select($select)->orderBy('id', 'desc')->limit(1)->get()->toArray();
                }

                if (isset($data['childcatagory'][1]['id'])) {
                    $data['newslist2'] = News::where(['IsActive' => 1, 'SubCategoryID' => $data['childcatagory'][1]['id']])->select($select)->orderBy('id', 'desc')->limit(4)->get()->toArray();
                }

                if (isset($data['childcatagory'][2]['id'])) {
                    $data['newslist3'] = News::where(['IsActive' => 1, 'SubCategoryID' => $data['childcatagory'][2]['id']])->select($select)->orderBy('id', 'desc')->limit(1)->get()->toArray();
                }

                if (isset($data['childcatagory'][3]['id'])) {
                    $data['newslist4'] = News::where(['IsActive' => 1, 'SubCategoryID' => $data['childcatagory'][3]['id']])->select($select)->orderBy('id', 'desc')->limit(9)->get()->toArray();
                }

                if (isset($data['childcatagory'][4]['id'])) {
                    $data['newslist5'] = News::where(['IsActive' => 1, 'SubCategoryID' => $data['childcatagory'][4]['id']])->select($select)->orderBy('id', 'desc')->limit(4)->get()->toArray();
                }

            } else {

                $data['newslist'] = $data['newslist']->where('TodaysCategory', '>', 0);

                if (isset($data['childcatagory'][0]['id'])) {
                    $data['newslist1'] = News::where(['IsActive' => 1, 'TodaysCategory' => $data['childcatagory'][0]['id']])->select($select)->orderBy('id', 'desc')->limit(1)->get()->toArray();
                }
                if (isset($data['childcatagory'][1]['id'])) {
                    $data['newslist2'] = News::where(['IsActive' => 1, 'TodaysCategory' => $data['childcatagory'][1]['id']])->select($select)->orderBy('id', 'desc')->limit(4)->get()->toArray();
                }
                if (isset($data['childcatagory'][2]['id'])) {
                    $data['newslist3'] = News::where(['IsActive' => 1, 'TodaysCategory' => $data['childcatagory'][2]['id']])->select($select)->orderBy('id', 'desc')->limit(1)->get()->toArray();
                }
                if (isset($data['childcatagory'][3]['id'])) {
                    $data['newslist4'] = News::where(['IsActive' => 1, 'TodaysCategory' => $data['childcatagory'][3]['id']])->select($select)->orderBy('id', 'desc')->limit(9)->get()->toArray();
                }
                if (isset($data['childcatagory'][4]['id'])) {
                    $data['newslist5'] = News::where(['IsActive' => 1, 'TodaysCategory' => $data['childcatagory'][4]['id']])->select($select)->orderBy('id', 'desc')->limit(4)->get()->toArray();
                }
            }
        }
        $data['newslist'] = $data['newslist']->orderBy('id','desc')->select($select)->paginate(20);
        return view('frontend.categories', compact('data'));
    }
}
