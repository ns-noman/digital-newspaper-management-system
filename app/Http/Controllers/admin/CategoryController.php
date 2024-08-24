<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['item'] = Category::find($id);
        }else{
            $data['title'] = 'Create';
        }
        $data['parent_categoris'] = Category::where('ParentID', 0)->orderBy('Caption', 'asc')->get();
        return view('admin.categories.create-or-edit',compact('data'));
    }


    public function store(Request $request)
    {
        $data = $request->all();
        $data['UserID'] = Auth::guard('admin')->user()->id;
        if($data['ParentID']) $data['ParentName'] = Category::find($data['ParentID'])->Caption;
        $category = Category::create($data);
        return redirect()->route('categories.index')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }


    public function update(Request $request,$id)
    {
        $category = Category::find($id);
        $data = $request->all();
        $data['UserID'] = Auth::guard('admin')->user()->id;
        $data['ParentName'] = null;
        if($data['ParentID']) $data['ParentName'] = Category::find($data['ParentID'])->Caption;
        $category->update($data);
        return redirect()->route('categories.index')->with('alert',['messageType'=>'warning','message'=>'Data Updated Successfully!']);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if(true) return redirect()->back()->with('alert',['messageType'=>'danger','message'=>'Data Deletion Failed!']);
        $category->delete();
        return redirect()->back()->with('alert',['messageType'=>'success','message'=>'Data Deleted Successfully!']);
    }
}
