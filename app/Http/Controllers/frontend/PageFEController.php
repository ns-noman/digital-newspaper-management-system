<?php

namespace App\Http\Controllers\frontend;

use App\Models\Page;
use App\Http\Controllers\Controller;


class PageFEController extends Controller
{
    public function index($slug)
    {   
        $array = explode('-', $slug);
        $id = end($array);
        $data['pagedetail'] =  Page::where(['IsActive'=>1,'id'=>$id])->first();
        return view('frontend.pages', compact('data'));
    }
}
