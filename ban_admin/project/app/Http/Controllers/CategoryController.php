<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;

use Modules\CacheControlls\Http\Controllers\CacheControllsController;
use Illuminate\Support\Facades\Redis;

use App\Category;
use Auth;
use DB;
use Session;

class CategoryController extends Controller
{

    public function index(){
        $categories = $this->getCategories();
        return view('category')->with('categories', $categories);
    }


    public function getCategories(){
    	$results = array();
        $categories = DB::table('categories')->select('id', 'display_name as category_name', 'title', 'color',  'header_display', 'menubar_display', 'edition', 'meta_title', 'meta_description', 'meta_keywords', 'header_code', 'status', 'order_id')->where('parent', 0)->where('status', '!=', 2)->orderBy('order_id')->get();

        foreach ($categories as $category) {
          $category->subCategory_name = "";
          $category->parent = "";
          array_push($results, $category);

          $subCategories = DB::table('categories')->select('id', 'display_name as subCategory_name', 'title', 'color', 'header_display', 'menubar_display', 'edition', 'meta_title', 'meta_description', 'meta_keywords', 'header_code', 'status', 'order_id')->where('parent', $category->id)->where('status', '!=', 2)->orderBy('order_id')->get();

          foreach ($subCategories as $subCategory){
            $subCategory->category_name = "";
            $subCategory->parent = $category->category_name;
            array_push($results, $subCategory);
        }
    }

    return $results;
}


public function upCategory($id){
    $category = Category::find($id);
    if($category->order_id > 1){
        Category::where('parent', $category->parent)->where('order_id', $category->order_id - 1)->update(['order_id' => $category->order_id]);
        Category::where('id', $id)->update(['order_id' => $category->order_id - 1]);
    }

    # redis regenrate
    $cacheController = new CacheControllsController;
    $cacheController->redisGenerateHeaderCategories();
    $cacheController->redisGenerateMenubarCategories();
    # redis regenrate

    return response()->json(true);
}


public function downCategory($id){
    $category = Category::find($id);
    $nextCategory = Category::where('parent', $category->parent)->where('order_id', '>', $category->order_id)->first();
    if(!empty($nextCategory)){
        Category::where('parent', $category->parent)->where('order_id', $category->order_id + 1)->update(['order_id' => $category->order_id]);
        Category::where('id', $id)->update(['order_id' => $category->order_id + 1]);
    }

    # redis regenrate
    $cacheController = new CacheControllsController;
    $cacheController->redisGenerateHeaderCategories();
    $cacheController->redisGenerateMenubarCategories();
    # redis regenrate

    return response()->json(true);
}


public static function getParentCategories(){
    return DB::table('categories')->select('id', 'display_name', 'order_id')->where('parent', 0)->orderBy('order_id')->get();
}


public static function store(Request $request){
    $category = new Category();
    $category->display_name = $request->display_name;
    $category->title = $request->title;
    $category->color = $request->color;
    $category->parent = $request->parent;
    $category->header_display = $request->header_display;
    $category->menubar_display = $request->menubar_display;
    $category->meta_title = $request->meta_title;
    $category->meta_description = $request->meta_description;
    $category->meta_keywords = $request->meta_keywords;
    $category->header_code = $request->header_code;
    $category->status = $request->status;
    $category->edition = $request->edition;
    $category->created_by = Auth::user()->id;
    $category->created_at = date('Y-m-d H:i:s');
    $category->order_id = Category::where('parent', $request->parent)->max('order_id') + 1;
    $category->save();

    # redis regenrate
    $cacheController = new CacheControllsController;
    $cacheController->redisGenerateHeaderCategories();
    $cacheController->redisGenerateMenubarCategories();
    # redis regenrate

    Session::flash('success_message', 'A new category has been created successfully.');
    return redirect()->back();
}



public static function edit($id){
    $category = DB::table('categories')->where('id', $id)->first();
    return response()->json(array('category' => $category));
}


public function update(Request $request){
    $category = Category::find($request->category_id);
    if($category->parent == $request->parent){
        $category->display_name = $request->display_name;
        $category->title = $request->title;
        $category->color = $request->color;
        $category->header_display = $request->header_display;
        $category->menubar_display = $request->menubar_display;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->meta_keywords = $request->meta_keywords;
        $category->header_code = $request->header_code;
        $category->edition = $request->edition;
        $category->status = $request->status;
        $category->updated_by = Auth::user()->id;
        $category->updated_at = date('Y-m-d H:i:s');
        $category->save();

            # redis regenrate
        $cacheController = new CacheControllsController;
        $cacheController->redisGenerateHeaderCategories();
        $cacheController->redisGenerateMenubarCategories();
            # redis regenrate

        Session::flash('success_message', 'Category has been updated successfully.');
        return redirect()->back();
    }else{
        Session::flash('info_message', 'You can not make a parent category to sub-category!');
        return redirect()->back();
    }

    Session::flash('info_message', 'Failed to update Category');
    return redirect()->back();
}


}
