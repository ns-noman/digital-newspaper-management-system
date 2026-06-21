<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Modules\CacheControlls\Http\Controllers\CacheControllsController;
use Illuminate\Support\Facades\Redis;
use Auth;
use Session;
use DB;
use Validator;
use App\Models\SettingsGeneral;
use App\Models\SettingsMeta;
use App\Models\SettingsSocial;

class SettingsController extends Controller
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
    

    public function general(){
        $data['generalInfo'] = SettingsGeneral::find(1);
        return view('settings::general', $data);
    }

    public function generalUpdate(Request $request){

        $validator = Validator::make($request->all(), [
            'newspaper_name' => 'string|nullable',
            'newspaper_name_bn' => 'string|nullable',
            'brand_color' => 'string|nullable',
            'hover_color' => 'string|nullable',
            'editor' => 'string|nullable',
            'publisher' => 'string|nullable',
            'online_head' => 'string|nullable',
            'mobile' => 'string|nullable',
            'email' => 'string|nullable',
            'footer' => 'string|nullable',
            'address' => 'string|nullable',
            'about' => 'string|nullable',
            'contact' => 'string|nullable',
            'privacy' => 'string|nullable',
            'terms' => 'string|nullable',
            'advertisement' => 'string|nullable',
            'logo_1' => 'image|nullable',
            'logo_2' => 'image|nullable',
            'icon_1' => 'image|nullable',
            'icon_2' => 'image|nullable',
            'default_img_1' => 'image|nullable',
            'default_img_2' => 'image|nullable',
            'show_topnews' => 'string|nullable',
            'show_selected2' => 'string|nullable',
            'show_live' => 'string|nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->to('settings/general')->withErrors($validator)->withInput()->with('errorMessage','Form validation failed!.');
        }

        try{
            DB::beginTransaction();

            $dataInfo = SettingsGeneral::find(1);
            $dataInfo->newspaper_name = trim($request->newspaper_name);
            $dataInfo->newspaper_name_bn = trim($request->newspaper_name_bn);
            $dataInfo->brand_color = trim($request->brand_color);
            $dataInfo->hover_color = trim($request->hover_color);
            $dataInfo->editor = trim($request->editor);
            $dataInfo->publisher = trim($request->publisher);
            $dataInfo->online_head = trim($request->online_head);
            $dataInfo->mobile = trim($request->mobile);
            $dataInfo->email = trim($request->email);
            $dataInfo->footer = trim($request->footer);
            $dataInfo->address = trim($request->address);
            $dataInfo->about = trim($request->about);
            $dataInfo->contact = trim($request->contact);
            $dataInfo->privacy = trim($request->privacy);
            $dataInfo->terms = trim($request->terms);
            $dataInfo->advertisement = trim($request->advertisement);
            $dataInfo->show_topnews = trim($request->show_topnews);
            $dataInfo->show_selected2 = $request->show_selected2 ? $request->show_selected2 : Null;
            $dataInfo->show_live = $request->show_live ? $request->show_live : Null;
            $dataInfo->updated_by = Auth::user()->id;
            $dataInfo->updated_at = date('Y-m-d H:i:s');

            if(!is_null($request->file('logo_1')))
            {
                $logo_1 = $request->file('logo_1');
                $base_name = preg_replace('/\..+$/', '', $logo_1->getClientOriginalName());
                $base_name = explode(' ', $base_name);
                $base_name = implode('-', $base_name);
                $image_name = $base_name."logo-1-".time().".".$logo_1->getClientOriginalExtension();

                $savingPath = env('UploadsFolderPath').'settings/';
                Storage::disk(env('DISK'))->putFileAs($savingPath, $logo_1, $image_name);

                $dataInfo->logo_1 = $image_name;
            }

            if(!is_null($request->file('logo_2')))
            {
                $logo_2 = $request->file('logo_2');
                $base_name = preg_replace('/\..+$/', '', $logo_2->getClientOriginalName());
                $base_name = explode(' ', $base_name);
                $base_name = implode('-', $base_name);
                $image_name = $base_name."logo-2-".time().".".$logo_2->getClientOriginalExtension();

                $savingPath = env('UploadsFolderPath').'settings/';
                Storage::disk(env('DISK'))->putFileAs($savingPath, $logo_2, $image_name);

                $dataInfo->logo_2 = $image_name;
            }

            if(!is_null($request->file('icon_1')))
            {
                $icon_1 = $request->file('icon_1');
                $base_name = preg_replace('/\..+$/', '', $icon_1->getClientOriginalName());
                $base_name = explode(' ', $base_name);
                $base_name = implode('-', $base_name);
                $image_name = $base_name."icon-1-".time().".".$icon_1->getClientOriginalExtension();

                $savingPath = env('UploadsFolderPath').'settings/';
                Storage::disk(env('DISK'))->putFileAs($savingPath, $icon_1, $image_name);

                $dataInfo->icon_1 = $image_name;
            }

            if(!is_null($request->file('icon_2')))
            {
                $icon_2 = $request->file('icon_2');
                $base_name = preg_replace('/\..+$/', '', $icon_2->getClientOriginalName());
                $base_name = explode(' ', $base_name);
                $base_name = implode('-', $base_name);
                $image_name = $base_name."icon-2-".time().".".$icon_2->getClientOriginalExtension();

                $savingPath = env('UploadsFolderPath').'settings/';
                Storage::disk(env('DISK'))->putFileAs($savingPath, $icon_2, $image_name);

                $dataInfo->icon_2 = $image_name;
            }

            if(!is_null($request->file('default_img_1')))
            {
                $default_img_1 = $request->file('default_img_1');
                $base_name = preg_replace('/\..+$/', '', $default_img_1->getClientOriginalName());
                $base_name = explode(' ', $base_name);
                $base_name = implode('-', $base_name);
                $image_name = $base_name."default-img-1-".time().".".$default_img_1->getClientOriginalExtension();

                $savingPath = env('UploadsFolderPath').'settings/';
                Storage::disk(env('DISK'))->putFileAs($savingPath, $default_img_1, $image_name);

                $dataInfo->default_img_1 = $image_name;
            }

            if(!is_null($request->file('default_img_2')))
            {
                $default_img_2 = $request->file('default_img_2');
                $base_name = preg_replace('/\..+$/', '', $default_img_2->getClientOriginalName());
                $base_name = explode(' ', $base_name);
                $base_name = implode('-', $base_name);
                $image_name = $base_name."default-img-2-".time().".".$default_img_2->getClientOriginalExtension();

                $savingPath = env('UploadsFolderPath').'settings/';
                Storage::disk(env('DISK'))->putFileAs($savingPath, $default_img_2, $image_name);

                $dataInfo->default_img_2 = $image_name;
            }

            $dataInfo->save();
            DB::commit();

            # redis regenrate
            $cacheController = new CacheControllsController;
            $cacheController->redisGenerateSettingsInfo();
            # redis regenrate

            return redirect()->to('settings/general')->with('success_message', 'General settings updated successfully.');

        }catch(Exception $e){
          DB::rollback();
          return redirect()->to('settings/general')->with('error_message', 'Failed to update General settings.');
      }

  }


  public function meta(){
    $data['metaInfo'] = SettingsMeta::find(1);
    return view('settings::meta', $data);
}


public function metaUpdate(Request $request){

    $validator = Validator::make($request->all(), [
        'title' => 'string|nullable',
        'domain' => 'string|nullable',
        'keywords' => 'string|nullable',
        'description' => 'string|nullable',
        'fb_pages' => 'string|nullable',
        'fb_app_id' => 'string|nullable',
        'twitter_username' => 'string|nullable',
        'refresh' => 'string|nullable',
        'header_code' => 'string|nullable',
        'body_code' => 'string|nullable',
        'search_plugin' => 'string|nullable',
    ]);

    if ($validator->fails()) {
        return redirect()->to('settings/meta')->withErrors($validator)->withInput()->with('errorMessage','Form validation failed!.');
    }

    try{

        DB::beginTransaction();

        $dataInfo = SettingsMeta::find(1);
        $dataInfo->title = trim($request->title);
        $dataInfo->domain = trim($request->domain);
        $dataInfo->keywords = trim($request->keywords);
        $dataInfo->description = trim($request->description);
        $dataInfo->fb_pages = trim($request->fb_pages);
        $dataInfo->fb_app_id = trim($request->fb_app_id);
        $dataInfo->twitter_username = trim($request->twitter_username);
        $dataInfo->refresh = trim($request->refresh);
        $dataInfo->header_code = trim($request->header_code);
        $dataInfo->body_code = trim($request->body_code);
        $dataInfo->search_plugin = trim($request->search_plugin);
        $dataInfo->updated_by = Auth::user()->id;
        $dataInfo->updated_at = date('Y-m-d H:i:s');
        $dataInfo->save();

        DB::commit();

        # redis regenrate
        $cacheController = new CacheControllsController;
        $cacheController->redisGenerateSettingsInfo();
        # redis regenrate

        return redirect()->to('settings/meta')->with('success_message', 'Meta settings updated successfully.');

    }catch(\Exception $e){
        DB::rollback();
        return redirect()->to('settings/meta')->with('error_message', 'Failed to update Meta settings.');
    }
}


public function social(){
    $data['socialInfo'] = SettingsSocial::find(1);
    return view('settings::social', $data);
}


public function socialUpdate(Request $request){

    $validator = Validator::make($request->all(), [
        'facebook' => 'string|nullable',
        'twitter' => 'string|nullable',
        'instagram' => 'string|nullable',
        'google' => 'string|nullable',
        'linkedin' => 'string|nullable',
        'youtube' => 'string|nullable',
        'android' => 'string|nullable',
        'ios' => 'string|nullable',
        'rss' => 'string|nullable',
        'another_site' => 'string|nullable',
        'another_site2' => 'string|nullable',
    ]);

    if ($validator->fails()) {
        return redirect()->to('settings/social')->withErrors($validator)->withInput()->with('errorMessage','Form validation failed!.');
    }

    try{

        DB::beginTransaction();

        $dataInfo = SettingsSocial::find(1);
        $dataInfo->facebook = trim($request->facebook);
        $dataInfo->twitter = trim($request->twitter);
        $dataInfo->instagram = trim($request->instagram);
        $dataInfo->google = trim($request->google);
        $dataInfo->linkedin = trim($request->linkedin);
        $dataInfo->youtube = trim($request->youtube);
        $dataInfo->android = trim($request->android);
        $dataInfo->ios = trim($request->ios);
        $dataInfo->rss = trim($request->rss);
        $dataInfo->another_site = trim($request->another_site);
        $dataInfo->another_site2 = trim($request->another_site2);
        $dataInfo->updated_by = Auth::user()->id;
        $dataInfo->updated_at = date('Y-m-d H:i:s');
        $dataInfo->save();

        DB::commit();

        # redis regenrate
        $cacheController = new CacheControllsController;
        $cacheController->redisGenerateSettingsInfo();
        # redis regenrate

        return redirect()->to('settings/social')->with('success_message', 'Social settings updated successfully.');

    }catch(\Exception $e){
        DB::rollback();
        return redirect()->to('settings/social')->with('error_message', 'Failed to update Social settings.');
    }
}


public function showTopNewsUpdate(Request $request){

    $validator = Validator::make($request->all(), [
        'show_topnews' => 'numeric|required',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput()->with('errorMessage','Form validation failed!.');
    }

    try{

        DB::beginTransaction();

        $dataInfo = SettingsGeneral::find(1);
        $dataInfo->show_topnews = !empty($request->show_topnews) ? $request->show_topnews : Null;
        $dataInfo->save();

        DB::commit();

        # redis regenrate
        $cacheController = new CacheControllsController;
        $cacheController->redisGenerateSettingsInfo();
        # redis regenrate

        return redirect()->back()->with('success_message', 'Number of top news updated successfully.');

    }catch(\Exception $e){
        DB::rollback();
        return redirect()->back()->with('error_message', 'Failed to update number of top news.');
    }
}


public function sshowSelectedNewsUpdate(Request $request){

    $validator = Validator::make($request->all(), [
        'show_selected2' => 'numeric|nullable',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput()->with('errorMessage','Form validation failed!.');
    }

    try{

        DB::beginTransaction();

        $dataInfo = SettingsGeneral::find(1);
        $dataInfo->show_selected2 = !empty($request->show_selected2) ? $request->show_selected2 : Null;
        $dataInfo->save();

        DB::commit();

        # redis regenrate
        $cacheController = new CacheControllsController;
        $cacheController->redisGenerateSettingsInfo();
        # redis regenrate

        return redirect()->back()->with('success_message', 'Selected2 display updated successfully.');

    }catch(\Exception $e){
        DB::rollback();
        return redirect()->back()->with('error_message', 'Failed to update selected2 display.');
    }
}

public function liveDisplayUpdate(Request $request){

    $validator = Validator::make($request->all(), [
        'show_live' => 'numeric|nullable',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput()->with('errorMessage','Form validation failed!.');
    }

    try{

        DB::beginTransaction();

        $dataInfo = SettingsGeneral::find(1);
        $dataInfo->show_live = !empty($request->show_live) ? $request->show_live : Null;
        $dataInfo->save();

        DB::commit();

        # redis regenrate
        $cacheController = new CacheControllsController;
        $cacheController->redisGenerateSettingsInfo();
        # redis regenrate

        return redirect()->back()->with('success_message', 'Live display updated successfully.');

    }catch(\Exception $e){
        DB::rollback();
        return redirect()->back()->with('error_message', 'Failed to update live display.');
    }
}


public static function settingsInfo(){
    $settingsInfo = DB::table('settings_general')->leftjoin('settings_meta', 'settings_meta.settings_id', '=', 'settings_general.id')->leftjoin('settings_social', 'settings_social.settings_id', '=', 'settings_general.id')->first();
    return $settingsInfo;
}

}
