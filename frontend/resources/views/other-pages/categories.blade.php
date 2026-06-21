@extends('layouts.layout')
@push('meta-tag')
<title>{!! !empty($pageInfo) ? $pageInfo->meta_title : 'সব বিভাগ - '.$settingsInfo->title !!}</title>
<meta property="og:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'সব বিভাগ - '.$settingsInfo->title !!}" />
<meta name="twitter:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'সব বিভাগ - '.$settingsInfo->title !!}" />
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
	<div class="container ">
		<div class="row">

			<!-- header -->
			<div class="col-sm-12 col-md-12 marginB20 hidden-xs">
				<div class="borderC1B1">
					<h1 class="desktopCategoryTitle"><strong><span class="leftSpan"></span> সব বিভাগ</strong></h1>
				</div>
			</div>
			<div class="col-sm-12 col-md-12 paddingLR20 marginB15 visible-xs paddingT10 marginT10">
				<h1 class="sectionTitle displayInline border0 margin0 marginB0"><strong><span class="leftSpan"></span> সব বিভাগ</strong></h1>
			</div>

			<div class="col-sm-9 col-md-9">
				<div class="row">
					<div class="col-sm-12 col-md-12 marginB20">
						<form method="get">
							<input type="hidden" name="search" value="yes">
							<div class="panel panel-default borderC1-1 borderRadius5 marginB0">
								<div class="panel-body">
									<div class="row marginLR-10">
										<div class="col-md-9 paddingLR7">
											<div>
												<input value="{{isset($_GET['categoryTitle'])&& !empty($_GET['categoryTitle']) ? $_GET['categoryTitle'] : ''}}" name="categoryTitle" class="form-control borderRadius5" type="text" placeholder="বিভাগ খুঁজুন">
											</div>
										</div>
										<div class="col-md-3 paddingLR7 xs-marginT10">
											<button type="submit" class="btn btn-block borderRadius5 width100P bgRed title1_8 colorWhite h34 padding3"><i class="fa fa-search title1_3"></i> খুঁজুন </button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="row borderC1-1 borderRadius5 margin0">
					@if(!empty($categories) && (count($categories)>0))
					@foreach($categories as $list)
					<div class="col-sm-12 col-md-12 marginT10 marginB20">
						<p class="sectionTitle marginB5 border0"><a aria-label="{!! $list->display_name !!}" href="{!! url($list->title) !!}"><strong><i class="fa fa-caret-right"></i> {!! $list->display_name !!}</strong></a></p>
						<!-- subcategories -->
						@if(!empty($list->subCategories) && (count($list->subCategories)>0))
						<div class="desktopSubCategoryDiv">
							<ul>
								@foreach($list->subCategories as $key => $subCat)
								<li><i class="fa fa-circle"></i> <p><a aria-label="{!! $subCat->display_name !!}" href="{!! url($subCat->title) !!}">{!! $subCat->display_name !!}</a></p></li>
								@endforeach
							</ul>
						</div>
						@endif
					</div>
					@endforeach
					@else
					<div class="col-md-12 padding15 xs-marginB10 title3 xs-title3 text-center">
						{{isset($_GET['categoryTitle'])&& !empty($_GET['categoryTitle']) ? $_GET['categoryTitle'] : ''}} নামে কোন বিভাগ পাওয়া যায়নি।
						<br>
						<br>
						<a href="{!! url('categories') !!}" class="allNewsButton textDecorationNone colorWhiteImp cursorPointer fontSize16">REFRESH</a>
					</div>
					@endif
				</div>
			</div>

			<!-- first sidebar -->
			<div class="col-sm-3 col-md-3 hidden-xs">
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