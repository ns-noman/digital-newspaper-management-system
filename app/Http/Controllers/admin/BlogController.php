<?php

namespace App\Http\Controllers\admin;

use App\Models\BlogCategory;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with(['blogcategory','user'])->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $blogCategorys = BlogCategory::get();
        return view('admin.blogs.create', compact('blogCategorys'));
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $data['slug'] = strtolower(str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strip_tags($request->title)))));
        $data['created_by'] = Auth::guard('admin')->user()->id;
        $fileName = 'blog-'. time().'.'. $data['image']->getClientOriginalExtension();
        $data['image']->move(public_path('uploads/blog'), $fileName);
        $data['image'] = $fileName;
        Blog::create($data);
        return redirect('admin/blogs')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }
    public function edit(Blog $blog)
    {
        $blogCategorys = BlogCategory::get();
        return view('admin.blogs.edit', compact('blog', 'blogCategorys'));
    }
    public function update(Request $request, Blog $blog)
    {
        $data = $request->all();
        $data['slug'] = strtolower(str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strip_tags($request->title)))));
        $data['created_by'] = Auth::guard('admin')->user()->id;
        
        if(isset($data['image'])){
            $fileName = 'blog-'. time().'.'. $data['image']->getClientOriginalExtension();
            $data['image']->move(public_path('uploads/blog'), $fileName);
            $data['image'] = $fileName;

            $imagePath = public_path('uploads/blog/'.$blog->image);
            if($blog->image) unlink($imagePath);
        }
        
        $blog->update($data);
        return redirect('admin/blogs')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);
    }

    public function localization(Request $request, $id, $locale)
    {
        if($request->isMethod('post'))
        {
            Blog::find($id)->update([$locale=>$request->all(),]);
            return redirect('admin/blogs')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);
        }else{
            $data = Blog::find($id)->translate($locale);
            return view('admin.blogs.localization', compact('data','id','locale'));
        }
    }

    public function destroy(Blog $blog)
    {
        $imagePath = public_path('uploads/blog/'.$blog->image);
        if($blog->image) unlink($imagePath);
        $blog->delete();
        return redirect()->back()->with('alert',['messageType'=>'danger','message'=>'Data Deleted Successfully!']);
    }
}
