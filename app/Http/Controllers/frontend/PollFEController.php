<?php

namespace App\Http\Controllers\frontend;

use App\Models\Poll;
use App\Models\BasicInfo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PollFEController extends Controller
{
    public function result()
    {
        $data['BasicInfo'] = BasicInfo::first();
        $data['onlinepoll'] = Poll::where(['IsActive'=>1,'IsClosed'=>'Yes'])->orderByDesc('id')->paginate(5);
        $data['title'] = "Poll Rsult | ". $data['BasicInfo']["SiteName"];
		$data['description'] = "Poll Rsult | ". $data['BasicInfo']["SiteName"];
        $data['parentcategoryname'] = "Poll Result";
        return view('frontend.polls',compact('data'));
    }
    public function vote(Request $request)
    {
        $poll_id = substr(substr($_POST['poll_id'], 4), 0, -4);
        $value_id = $_POST['value_id'];
        $poll = Poll::where(['id'=>$poll_id,'IsClosed'=>'No','IsActive'=>1])->first();
        if ($value_id == 'Positive') {
            $field = 'PositiveComment';
            $field_value = $poll->PositiveComment+1;
        } elseif ($value_id == 'Negative') {
            $field = "NegativeComment";
            $field_value = $poll->NegativeComment+1;
        } elseif ($value_id == 'NoComment') {
            $field = "NoComment";
            $field_value = $poll->NoComment+1;
        }
        $poll->update([$field=>$field_value]);
        return response()->json(['result'=> 'Your voting has been completed. Thanks'], 200);
    }
}
