@extends('layouts.layout')
@push('meta-tag')
<title>{!! !empty($pageInfo) ? $pageInfo->meta_title : $linkCategory->title !!}</title>
<meta property="og:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : $linkCategory->title !!}" />
<meta name="twitter:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : $linkCategory->title !!}" />
<meta name="description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : $linkCategory->description !!}" />
<meta property="og:description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : $linkCategory->description !!}" />
<meta name="twitter:description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : $linkCategory->description !!}" />
<meta name="keywords" content="{!! !empty($pageInfo) ? $pageInfo->meta_keywords : $linkCategory->title !!}" />
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
					<h1 class="desktopCategoryTitle"><strong><span class="leftSpan"></span> {!! $linkCategory->title !!}</strong></h1>
				</div>
				@if(!empty($linkCategory->description))
				<div class="marginT10 title12">
					{!! $linkCategory->description !!}
				</div>
				@endif
			</div>
			<div class="col-sm-12 col-md-12 paddingLR20 marginB15 visible-xs paddingT10 marginT10">
				<h1 class="sectionTitle displayInline border0 margin0 marginB0"><strong><span class="leftSpan"></span> {!! $linkCategory->title !!}</strong></h1>
				@if(!empty($linkCategory->description))
				<div class="marginT10 title12">
					{!! $linkCategory->description !!}
				</div>
				@endif
			</div>

			<div class="col-sm-12 col-md-12">
				@if(!empty($linkCategory) && !empty($linkCategory->links) && (count($linkCategory->links)>0))
				<div class="row marginB30 text-center marginT10">
					@foreach($linkCategory->links as $key => $link)
					<div class="col-sm-3 col-md-3 col-xs-6 desktopSectionLead marginB20">
						<div class="thumbnail bg2 borderC1-1 borderRadius5Imp h100P">
							@if(!empty($link->photo))
							<div class="positionRelative borderC1B1">
								<img src="{{asset('uploads/links/'.$link->photo)}}" class="img-responsive borderTRadius5" alt="{!! $link->title !!}">
							</div>
							@endif
							<div class="caption paddingTB0 paddingLR10Imp">
								<p class="title11 marginT0 colorBlackImp">{!! $link->title !!}</p>
							</div>
							<a aria-label="{!! $link->title !!}" rel="nofollow" href="{!! $link->link !!}" target="_blank" class="linkOverlay"></a>
						</div>
					</div>
					@endforeach
				</div>
				@endif
			</div>
		</div>
	</div>
</div>
<!-- desktop and mobile version end -->
@endsection

@push('js')

@endpush