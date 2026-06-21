@extends('layouts.layout')
@push('meta-tag')
<title>{!! !empty($pageInfo) ? $pageInfo->meta_title : 'লেখক - '.$settingsInfo->title !!}</title>
<meta property="og:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'লেখক - '.$settingsInfo->title !!}" />
<meta name="twitter:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'লেখক - '.$settingsInfo->title !!}" />
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

<!-- breadcrumb -->
<div class="row">
	<div class="col-md-12">
		<div class="pageTitle">
			<h1><a href="{!! Request::url() !!}">লেখক</a></h1>
			<p class="catBottomBorder"><span></span></p>
		</div>
	</div>
</div>

<!-- author section -->
<div class="row marginT10">
	<div class="col-md-8">
		<div class="row flex-row">
			@if(!empty($authors) && (count($authors)>0))
			@foreach($authors as $key => $author)
			<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 flex-col marginB25">
				<div class="card hovercard bgAshLight marginT0 marginT0 paddingB0 width100P height100P">
					<div class="cardheader">
					</div>
					<div class="avatar">
						@if(!empty($author->author_photo))
						<img src="{{asset('uploads/authors/'.$author->author_photo)}}" alt="{{$author->author_name}}" title="{{$author->author_name}}">
						@else
						<img src="{{asset('uploads/authors/default-avatar.png')}}" alt="{{$author->author_name}}" title="{{$author->author_name}}">
						@endif
					</div>
					<div class="info">
						<div class="title">
							<a class="title3 xs-title3 colorBlack hoverOrange textDecorationNone" href="{{url('author/'.$author->id.'/'.$author->author_slug)}}">{{$author->author_name}}</a>
						</div>
						@if(!empty($author->author_about))
						<div class="desc">{{$author->author_about}}</div>
						@endif
					</div>
					<p class="topSocialIcon topSocialIconColored marginT0 marginB0">
						<a href="{{$author->facebook ? $author->facebook : '#'}}" target="_blank" class="fa fa-facebook"></a>
						<a href="{{$author->twitter ? $author->twitter : '#'}}" target="_blank" class="fa fa-twitter"></a>
						<a href="{{$author->linkedin ? $author->linkedin : '#'}}" target="_blank" class="fa fa-linkedin"></a>
					</p>
				</div>
			</div>
			@endforeach
			@endif
		</div>
	</div>


	<div class="col-md-4 xs-marginT20 marginT10">
		<!-- latest news -->
		<div class="row">
			<div class="col-md-12 lpnw">
				<div class="loadingDiv1"><i class="fa fa-spinner"></i></div>
				<div class="latestNewsWidget mediaItemDiv" style="display: none;">
					<p class="lpnwCartHeader"><a href="{{url('latest')}}">সর্বশেষ</a>
					</p>
					<div class="ajaxLatestNewsDiv"></div>
				</div>
			</div>
		</div>
		<!-- end latest news -->
	</div>
</div>

@endsection

@push('js')
<!-- ajax load latest news -->
<script type="text/javascript">
	var url = '{{url("ajax/load/latestnews/")}}/4/0/0';
	$.get(url, function(data){
		if(data != ''){
			$.each(data, function(key, value){
				$('.loadingDiv1').hide();
				if(value.video_code != null){
					var icon = '<span class="pvIconSmall top50P"><i class="fa fa-play"></i></span>';
				}else{
					var icon = '';
				}
				var row = $('<div class="media"><div class="media-left"><div class="positionRelative"><img width="140" class="media-object" src="'+value.thumb+'" alt="'+value.headline+'" title="'+value.headline+'">'+icon+'</div></div><div class="media-body"><h2>'+value.headline+'</h2></div><a href="'+value.url+'" class="linkOverlay"></a></div>');
				$('.ajaxLatestNewsDiv').append(row);
			});				
			$('.latestNewsWidget').show();
		}
	});
</script>
@endpush