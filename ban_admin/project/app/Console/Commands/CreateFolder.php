<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;

use Illuminate\Support\Facades\Storage;

class CreateFolder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:createFolder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
    	parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
    	$today = date('Y/m/d');
    	$nextday = date('Y/m/d', strtotime('+1 day'));

    	$todayPhotoPath = env('NewAssetFolderPath').'news_photos/'.$today;
    	$nextdayPhotoPath = env('NewAssetFolderPath').'news_photos/'.$nextday;
    	if(!Storage::disk(env('DISK'))->exists($todayPhotoPath)){
    		Storage::disk(env('DISK'))->makeDirectory($todayPhotoPath, 0777);
    	}
    	if(!Storage::disk(env('DISK'))->exists($nextdayPhotoPath)){
    		Storage::disk(env('DISK'))->makeDirectory($nextdayPhotoPath, 0777);
    	}


    	$todayPhotoPathSmall = env('NewAssetFolderPath').'news_photos/'.$today.'/small';
    	$nextdayPhotoPathSmall = env('NewAssetFolderPath').'news_photos/'.$nextday.'/small';
    	if(!Storage::disk(env('DISK'))->exists($todayPhotoPathSmall)){
    		Storage::disk(env('DISK'))->makeDirectory($todayPhotoPathSmall, 0777);
    	}
    	if(!Storage::disk(env('DISK'))->exists($nextdayPhotoPathSmall)){
    		Storage::disk(env('DISK'))->makeDirectory($nextdayPhotoPathSmall, 0777);
    	}


    	$todayPhotoPathMedium = env('NewAssetFolderPath').'news_photos/'.$today.'/medium';
    	$nextdayPhotoPathMedium = env('NewAssetFolderPath').'news_photos/'.$nextday.'/medium';
    	if(!Storage::disk(env('DISK'))->exists($todayPhotoPathMedium)){
    		Storage::disk(env('DISK'))->makeDirectory($todayPhotoPathMedium, 0777);
    	}
    	if(!Storage::disk(env('DISK'))->exists($nextdayPhotoPathMedium)){
    		Storage::disk(env('DISK'))->makeDirectory($nextdayPhotoPathMedium, 0777);
    	}


    	$todayPhotoPathSocialThumb = env('NewAssetFolderPath').'news_photos/'.$today.'/social-thumbnail';
    	$nextdayPhotoPathSocialThumb = env('NewAssetFolderPath').'news_photos/'.$nextday.'/social-thumbnail';
    	if(!Storage::disk(env('DISK'))->exists($todayPhotoPathSocialThumb)){
    		Storage::disk(env('DISK'))->makeDirectory($todayPhotoPathSocialThumb, 0777);
    	}
    	if(!Storage::disk(env('DISK'))->exists($nextdayPhotoPathSocialThumb)){
    		Storage::disk(env('DISK'))->makeDirectory($nextdayPhotoPathSocialThumb, 0777);
    	}


    	$todayPhotoPathFiles = env('NewAssetFolderPath').'news_photos/'.$today.'/files';
    	$nextdayPhotoPathFiles = env('NewAssetFolderPath').'news_photos/'.$nextday.'/files';
    	if(!Storage::disk(env('DISK'))->exists($todayPhotoPathFiles)){
    		Storage::disk(env('DISK'))->makeDirectory($todayPhotoPathFiles, 0777);
    	}
    	if(!Storage::disk(env('DISK'))->exists($nextdayPhotoPathFiles)){
    		Storage::disk(env('DISK'))->makeDirectory($nextdayPhotoPathFiles, 0777);
    	}


    	$todayHitPath = env('NewAssetFolderPath').'news_hit/'.$today;
    	$nextdayHitPath = env('NewAssetFolderPath').'news_hit/'.$nextday;
    	if(!Storage::disk(env('DISK'))->exists($todayHitPath)){
    		Storage::disk(env('DISK'))->makeDirectory($todayHitPath, 0777);
    	}
    	if(!Storage::disk(env('DISK'))->exists($nextdayHitPath)){
    		Storage::disk(env('DISK'))->makeDirectory($nextdayHitPath, 0777);
    	}

    	return 'done';
    }
}
