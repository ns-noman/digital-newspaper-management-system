<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Storage;
use Schema;

class TableController extends Controller
{


  /**
     * Create required folders for the current month.
     */

  public function createRequiredFolders($dateTime = Null)
  {

      if(!empty($dateTime)){
          $dateTime = date('Y-m-d', strtotime($dateTime));
      }else{
          $dateTime = date('Y-m-d');
      }

      Storage::disk(env('DISK'))->makeDirectory(env('NewAssetFolderPath').'news_photos'.date('/Y/m/d/', strtotime($dateTime)), 0777);
      Storage::disk(env('DISK'))->makeDirectory(env('NewAssetFolderPath').'news_photos'.date('/Y/m/d/', strtotime($dateTime)).'small/', 0777);
      Storage::disk(env('DISK'))->makeDirectory(env('NewAssetFolderPath').'news_photos'.date('/Y/m/d/', strtotime($dateTime)).'medium/', 0777);
      Storage::disk(env('DISK'))->makeDirectory(env('NewAssetFolderPath').'news_photos'.date('/Y/m/d/', strtotime($dateTime)).'social-thumbnail/', 0777);
      Storage::disk(env('DISK'))->makeDirectory(env('NewAssetFolderPath').'news_photos'.date('/Y/m/d/', strtotime($dateTime)).'files/', 0777);
      Storage::disk(env('DISK'))->makeDirectory(env('NewAssetFolderPath').'news_hit'.date('/Y/m/d/', strtotime($dateTime)), 0777);




      // if (!file_exists($filePath)){
      //     mkdir($filePath, 0777, true);
      // }

      // if (!file_exists($thumbPath))  
      // {
      //     mkdir($thumbPath, 0777, true);
      // }

      // if (!file_exists($photoPath))  
      // {
      //     mkdir($photoPath, 0777, true);
      // }

      // if (!file_exists($photoPath250x142))  
      // {
      //     mkdir($photoPath250x142, 0777, true);
      // }

      // if (!file_exists($photoPath150x85))  
      // {
      //     mkdir($photoPath150x85, 0777, true);
      // }

      // if (!file_exists($photoPathSocial))  
      // {
      //     mkdir($photoPathSocial, 0777, true);
      // }

  }

}
