<?php

namespace App\Http\Controllers\admin;

use App\Models\Page;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('id', 'desc')->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['item'] = Page::find($id);
        }else{
            $data['title'] = 'Create';
        }
        return view('admin.pages.create-or-edit',compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['UserID'] = Auth::guard('admin')->user()->id;
        Page::create($data);
        return redirect()->route('pages.index')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        Page::find($id)->update($data);
        return redirect()->route('pages.index')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    public function destroy($id)
    {
        try {
            Page::destroy($id);
            return redirect()->back()->with('alert', [
                'messageType' => 'success',
                'message' => 'writers deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', [
                'messageType' => 'warning',
                'message' => $e->getMessage()
            ]);
        }
    }

}
