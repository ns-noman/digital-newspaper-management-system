<?php

namespace App\Http\Controllers\admin;

use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('id', 'desc')->get();
        return view('admin.tags.index', compact('tags'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['item'] = Tag::find($id);
        }else{
            $data['title'] = 'Create';
        }
        return view('admin.tags.create-or-edit',compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Tag::create($data);
        return redirect()->route('tags.index')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function update(Request $request, $id)
    {
        $tag = Tag::find($id);
        $data = $request->all();
        $tag->update($data);
        return redirect()->route('tags.index')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    public function destroy($id)
    {
        try {
            $tag = Tag::findOrFail($id);
            if (1 > 0) {
                throw new \Exception('Cannot delete tag with associated items!');
            }
            $tag->delete();
            return redirect()->back()->with('alert', [
                'messageType' => 'success',
                'message' => 'Category deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', [
                'messageType' => 'warning',
                'message' => $e->getMessage()
            ]);
        }
    }

}
