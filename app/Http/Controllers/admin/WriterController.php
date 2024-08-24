<?php

namespace App\Http\Controllers\admin;

use App\Models\Writer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;


class WriterController extends Controller
{
    public function index()
    {
        $writers = Writer::orderBy('id', 'desc')->get();
        return view('admin.writers.index', compact('writers'));
        // foreach ($writers as $key => $writer) {
        //     $oldImage = $writer->Image;
        //     // $newImage = str_replace("img/","", $oldImage);
        //     $newImage = substr($oldImage, 14);
        //     // if($oldImage=="blank_face.png") $newImage = null;
        //     $writer->update(["Image"=> $newImage]);
        // }
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['item'] = Writer::find($id);
        }else{
            $data['title'] = 'Create';
        }
        return view('admin.writers.create-or-edit',compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['UserID'] = Auth::guard('admin')->user()->id;
        if(isset($data['Image'])){
            $fileName = 'writer-'. time().'.'. $data['Image']->getClientOriginalExtension();
            $data['Image']->move(public_path('uploads/writers'), $fileName);
            $data['Image'] = $fileName;
        }
        Writer::create($data);
        return redirect()->route('writers.index')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $writer = Writer::find($id); 
        if(isset($data['Image'])){
            $fileName = 'writer-'. time().'.'. $data['Image']->getClientOriginalExtension();
            $data['Image']->move(public_path('uploads/writers'), $fileName);
            $data['Image'] = $fileName;
            if($writer->Image) unlink(public_path('uploads/writers/'.$writer->Image));
        }
        $writer->update($data);
        return redirect()->route('writers.index')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    public function destroy($id)
    {
        try {
            $writer = Writer::findOrFail($id);
            if (1 > 3) {
                throw new \Exception('Cannot delete writers with associated post!');
            }
            if($writer->Image) unlink(public_path('uploads/writers/'.$writer->Image));
            $writer->delete();
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
