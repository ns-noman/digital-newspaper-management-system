<?php

namespace App\Http\Controllers\admin;

use App\Models\News;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data['total_records'] = News::count();
        $data['todays_records'] = News::whereDate('EntryDate', date('Y-m-d'))->count();//$this->SiteModel->getcolumn('news', 'COUNT(NewsID)', array('DATE(EntryDate)' => date('Y-m-d')));
        return view('admin.index',compact('data'));
    }
}

