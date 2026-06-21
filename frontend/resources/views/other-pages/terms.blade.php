@extends('layouts.layout')
@push('meta-tag')
<title>{!! !empty($pageInfo) ? $pageInfo->meta_title : 'Terms and Conditions - '.$settingsInfo->title !!}</title>
<meta property="og:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'Terms and Conditions - '.$settingsInfo->title !!}" />
<meta name="twitter:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'Terms and Conditions - '.$settingsInfo->title !!}" />
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
	<div class="container">
		<div class="row">
			<!-- header -->
			<div class="col-sm-12 col-md-12 marginB20 hidden-xs">
				<div class="borderC1B1">
					<h1 class="desktopCategoryTitle"><strong><span class="leftSpan"></span> Terms and Conditions</strong></h1>
				</div>
			</div>
			<div class="col-sm-12 col-md-12 paddingLR20 marginB15 visible-xs paddingT10 marginT10">
				<h1 class="sectionTitle displayInline border0 margin0 marginB0"><strong><span class="leftSpan"></span> Terms and conditions</strong></h1>
			</div>

			<div class="col-sm-9 col-md-9">
				<div class="marginB20 textBody">
					{!! $settingsInfo->terms ? $settingsInfo->terms : '' !!}
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