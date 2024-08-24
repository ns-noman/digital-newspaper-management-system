<?php

namespace App\Http\Controllers\admin;
use App\Models\BlogCategory;
use App\Models\Blog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $blogCategorys = BlogCategory::get();
        return view('admin.blog-categories.index', compact('blogCategorys'));
    }

    public function create()
    {
        return view('admin.blog-categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['cat_url'] = strtolower(str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strip_tags($request->cat_name)))));
        BlogCategory::create($data);
        return redirect('admin/blog-category');
    }

    public function edit(BlogCategory $blogCategory)
    {
        return view('admin.blog-categories.edit', compact('blogCategory'));
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $data = $request->all();
        $data['cat_url'] = strtolower(str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strip_tags($request->cat_name)))));
        $blogCategory->update($data);
        return redirect('admin/blog-category');
    }
    public function localization(Request $request, $id, $locale)
    {
        if($request->isMethod('post'))
        {
            BlogCategory::find($id)->update([$locale=>$request->all(),]);
            return redirect('admin/blog-category')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);
        }else{
            $data = BlogCategory::find($id)->translate($locale);
            return view('admin.blog-categories.localization', compact('data','id','locale'));
        }
    }
    public function destroy(BlogCategory $blogCategory)
    {
        $data = Blog::where('cat_id',$blogCategory->id)->get();
        if(count($data)) return redirect()->back()->with('alert',['messageType'=>'danger','message'=>'This data can not be delele!']);
        $blogCategory->delete();
        return redirect('admin/blog-category')->with('alert',['messageType'=>'danger','message'=>'Data Deleted Successfully!']);
    }
}
