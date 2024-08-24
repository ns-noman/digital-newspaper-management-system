<?php

namespace App\Http\Controllers\admin;

use App\Models\Reporter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ReporterController extends Controller
{
    public function index()
    {
        $reporters = Reporter::orderBy('id', 'desc')->get();
        return view('admin.reporters.index', compact('reporters'));
        // foreach ($reporters as $key => $reporter) {
        //     $oldImage = $reporter->Image;
            // $newImage = str_replace("img/","", $oldImage);
            // if($oldImage=='img/blank_face.png'){
            //     $reporter->update(["Image"=> null]);
            // }
            // $reporter->update(["Image"=> substr($oldImage, 21)]);
        // }
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['item'] = Reporter::find($id);
        }else{
            $data['title'] = 'Create';
        }
        return view('admin.reporters.create-or-edit',compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['UserID'] = Auth::guard('admin')->user()->id;
        if(isset($data['Image'])){
            $fileName = 'reporter-'. time().'.'. $data['Image']->getClientOriginalExtension();
            $data['Image']->move(public_path('uploads/reporters'), $fileName);
            $data['Image'] = $fileName;
        }
        Reporter::create($data);
        return redirect()->route('reporters.index')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $reporter = Reporter::find($id); 
        if(isset($data['Image'])){
            $fileName = 'reporter-'. time().'.'. $data['Image']->getClientOriginalExtension();
            $data['Image']->move(public_path('uploads/reporters'), $fileName);
            $data['Image'] = $fileName;
            if($reporter->Image) unlink(public_path('uploads/reporters/'.$reporter->Image));
        }
        $reporter->update($data);
        return redirect()->route('reporters.index')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    public function destroy($id)
    {
        try {
            $reporter = Reporter::findOrFail($id);
            if (true) {
                throw new \Exception('Cannot delete reporters with associated post!');
            }
            if($reporter->Image) unlink(public_path('uploads/reporters/'.$reporter->Image));
            $reporter->delete();
            return redirect()->back()->with('alert', [
                'messageType' => 'success',
                'message' => 'reporters deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', [
                'messageType' => 'warning',
                'message' => $e->getMessage()
            ]);
        }
    }

}
