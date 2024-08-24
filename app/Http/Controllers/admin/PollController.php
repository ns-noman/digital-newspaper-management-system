<?php

namespace App\Http\Controllers\admin;

use App\Models\Poll;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class PollController extends Controller
{
    public function index()
    {
        $polls = Poll::orderBy('id', 'desc')->get();
        return view('admin.polls.index', compact('polls'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['item'] = Poll::find($id);
        }else{
            $data['title'] = 'Create';
        }
        return view('admin.polls.create-or-edit',compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['UserID'] = Auth::guard('admin')->user()->id;
        Poll::create($data);
        return redirect()->route('polls.index')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $writer = Poll::find($id); 
        if(isset($data['Image'])){
            $fileName = 'writer-'. time().'.'. $data['Image']->getClientOriginalExtension();
            $data['Image']->move(public_path('uploads/polls'), $fileName);
            $data['Image'] = $fileName;
            if($writer->Image) unlink(public_path('uploads/polls/'.$writer->Image));
        }
        $writer->update($data);
        return redirect()->route('polls.index')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    public function destroy($id)
    {
        try {
            $writer = Poll::findOrFail($id);
            if (1 > 3) {
                throw new \Exception('Cannot delete polls with associated post!');
            }
            if($writer->Image) unlink(public_path('uploads/polls/'.$writer->Image));
            $writer->delete();
            return redirect()->back()->with('alert', [
                'messageType' => 'success',
                'message' => 'polls deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', [
                'messageType' => 'warning',
                'message' => $e->getMessage()
            ]);
        }
    }

}
