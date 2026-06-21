<?php

namespace Modules\Tools\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Http\Controllers\CommonController;
use DB;
use Auth;
use Session;
use Validator;
use App\Models\PhotoCarts;
use App\Models\Articles;
use App\Models\ArchiveArticles;
use App\Models\Polls;

class ToolsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function cards()
    {
      return view('tools::photo-cards.cards');
    }


    public function ajaxGeneratePhotoCard($newsId){
      if($newsId <= env('Old_NewsId')){
        $newsInfo = ArchiveArticles::where('id', $newsId)->where('status', 1)->first();
      }else{
        $newsInfo = Articles::where('id', $newsId)->where('status', 1)->first();
      }
      $imageUrl = $_GET['imageUrl'];
      $design = isset($_GET['design']) && !empty($_GET['design']) ? $_GET['design'] : 1;

      if(!empty($newsInfo) && !empty($imageUrl)){
        $data['b64image'] = 'data:image/jpeg;base64,'.base64_encode(file_get_contents($imageUrl));
        $data['newsInfo'] = $newsInfo;

        if(!empty($newsInfo->articleAuthors) && !empty($newsInfo->articleAuthors->author_photo)){
          $data['authorPhotos'] = 'data:image/jpeg;base64,'.base64_encode(file_get_contents(env('UploadsLink').'uploads/authors/'.$newsInfo->articleAuthors->author_photo));
          $data['authorNames'] = $newsInfo->articleAuthors->author_name;
        }
        $data['uniqueId'] = time();
        return view('tools::photo-cards.photocards.card'.$design, $data);
      }
    }


    public function ajaxGenerateCommentCard()
    {
      $design = isset($_GET['design']) && !empty($_GET['design']) ? $_GET['design'] : 1;
      $data['uniqueId'] = time();
      return view('tools::photo-cards.commentcards.card'.$design, $data);
    }

    public function ajaxGeneratePollCard($id){
      $pollInfo = Polls::where('id', $id)->where('status', 1)->first();
      $design = isset($_GET['design']) && !empty($_GET['design']) ? $_GET['design'] : 1;
      if(!empty($pollInfo)){
        $data['pollInfo'] = $pollInfo;
        $data['uniqueId'] = time();
        return view('tools::photo-cards.pollcards.card'.$design, $data);
      }
    }


  }
