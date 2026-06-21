@extends('layouts.layout')
@push('meta-tag')
<title>{!! !empty($pageInfo) ? $pageInfo->meta_title : 'খুঁজে পাওয়া যায়নি - '.$settingsInfo->title !!}</title>
<meta property="og:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'খুঁজে পাওয়া যায়নি - '.$settingsInfo->title !!}" />
<meta name="twitter:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'খুঁজে পাওয়া যায়নি - '.$settingsInfo->title !!}" />
<meta name="description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : $settingsInfo->description !!}" />
<meta property="og:description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : $settingsInfo->description !!}" />
<meta name="twitter:description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : $settingsInfo->description !!}" />
<meta name="keywords" content="{!! !empty($pageInfo) ? $pageInfo->meta_keywords : $settingsInfo->keywords !!}" />
<meta property="og:image" content="{!! !empty($pageInfo) && !empty($pageInfo->meta_image_src) ? $pageInfo->meta_image_src : asset('uploads/settings/'.$settingsInfo->default_img_1) !!}" />
<meta name="twitter:image" content="{!! !empty($pageInfo) && !empty($pageInfo->meta_image_src) ? $pageInfo->meta_image_src : asset('uploads/settings/'.$settingsInfo->default_img_1) !!}" />
<meta name="robots" content="index, follow" />
{!! !empty($pageInfo) ? $pageInfo->header_code : '' !!}
@endpush

@section('content')
<!-- desktop version and mobile start -->
<div class="bgWHite">
	<div class="container paddingT20">
		<div class="row">

			<div class="col-sm-9 col-md-9">
				<div class="marginB20">
					<p class="title10 colorBlack">খুঁজে পাওয়া যায়নি</p>
					<p class="title11 colorBlack">আপনি যা অনুসন্ধান করছেন তা খুঁজে পাওয়া যায়নি। বিষয়টি সম্ভবত {!! $settingsInfo->newspaper_name_bn !!}'র সঙ্গে সংশ্লিষ্ট নয়; অথবা আপনি ভুলভাবে অনুসন্ধান করছেন। অনুগ্রহ করে বিষয়টি সম্পর্কে নিশ্চিত হোন এবং সুনির্দিষ্টভাবে অনুসন্ধান করুন।</p>
					<p class="title11 colorBlack">ধন্যবাদ।</p>
				</div>
			</div>

			<!-- first sidebar -->
			<div class="col-sm-3 col-md-3">
				<!-- latest popular news -->
				<div class="row">
					<div class="col-sm-12 col-md-12 marginB20">
						@include('layouts.latest-popular-tab-news')
					</div>
				</div>
				<!-- latest popular news end -->
			</div>
		</div>
	</div>
</div>
<!-- desktop and mobile version end -->
@endsection

@push('js')

@endpush