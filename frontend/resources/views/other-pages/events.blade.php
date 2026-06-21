@extends('layouts.layout')
@push('meta-tag')
<title>{!! !empty($eventInfo) ? $eventInfo->event_title : 'ইভেন্টের খবর'.' - '.$settingsInfo->site_name !!}</title>
<meta property="og:title" content="{!! !empty($eventInfo) ? $eventInfo->event_title : 'ইভেন্টের খবর'.' - '.$settingsInfo->site_name !!}" />
<meta property="og:description" content="{!! !empty($eventInfo) ? $eventInfo->event_title : 'ইভেন্টের খবর'.' - '.$settingsInfo->site_name !!}" />
<meta name="description" content={!! !empty($eventInfo) ? $eventInfo->event_title : 'ইভেন্টের খবর'.' - '.$settingsInfo->site_name !!}"" />
<meta name="twitter:title" content="{!! !empty($eventInfo) ? $eventInfo->event_title : 'ইভেন্টের খবর'.' - '.$settingsInfo->site_name !!}" />
<meta name="twitter:description" content="{!! !empty($eventInfo) ? $eventInfo->event_title : 'ইভেন্টের খবর'.' - '.$settingsInfo->site_name !!}" />
<meta name="keywords" content="{!! !empty($eventInfo) ? $eventInfo->event_title : 'ইভেন্টের খবর'.' - '.$settingsInfo->site_name !!}" />
<meta property="og:image" content="{{asset('uploads/settings/'.$settingsInfo->default_img_1)}}" />
<meta name="twitter:image" content="{{asset('uploads/settings/'.$settingsInfo->default_img_1)}}" />
<meta name="robots" content="index, follow" />
{!! !empty($pageInfo) ? $pageInfo->header_code : '' !!}
@endpush

@section('content')

<!-- breadcrumb -->
<div class="row">
	<div class="col-md-12">
		<div class="pageTitle">
			<h1><a href="{!! Request::url() !!}">{!! !empty($eventInfo) ? $eventInfo->event_title : 'ইভেন্টের খবর' !!}</a></h1>
			<p class="catBottomBorder"><span></span></p>
		</div>
	</div>
</div>


<!-- news section -->
<div class="row marginT10">
	<div class="col-md-8">

		<!-- events -->
		<div class="row">
			<div class="col-md-12 marginB15">
				<div class="panel panel-default borderRadius0 bgAsh marginB0">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-8 xs-marginB10">
								<select name="event" class="form-control event borderRadius0">
									<option value="">--Select Event--</option>
									@if(!empty($events) && (count($events)>0))
									@foreach($events as $event)
									<option {{!empty($eventInfo) && ($eventInfo->id == $event->id) ? 'selected' : ''}} value="{!! $event->id !!}">{!! $event->event_title !!}</option>
									@endforeach
									@endif
								</select>
							</div>
							<div class="col-md-4 paddingL0 xs-paddingL15">
								<button type="button" class="btn btn-danger btn-block borderRadius0 width100P clickSearchEvent h34"><i class="fa fa-search"></i> Search </button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		@if(!empty($eventInfo->page_banner))
		<div class="row">
			<div class="col-md-12">
				<div class="bgWhite marginB15 hidden-xs">
					<img src="{{asset('uploads/events/pagebanners/'.$eventInfo->page_banner)}}" alt="{!! $eventInfo->event_title !!}" title="{!! $eventInfo->event_title !!}" class="width100P">
				</div>
				<div class="bgWhite marginB15 visible-xs">
					<img src="{{asset('uploads/events/clickbanners/'.$eventInfo->click_banner)}}" alt="{!! $eventInfo->event_title !!}" title="{!! $eventInfo->event_title !!}" class="width100P">
				</div>
			</div>
		</div>
		@endif

		@if(!empty($eventArticles) && (count($eventArticles)>0))
		<div class="row flex-row marginT10">
			@foreach($eventArticles as $list)
			@php $article = \App\Models\Helper::processArticleShortly($list, 20); @endphp
			<div class="col-md-12 flex-col marginB15 xs-marginB10">
				<div class="bgWhite mediaItemDiv height100P borderAshB1 paddingB15">
					<div class="media positionRelative hoverOrange marginT0">
						<div class="media-left">
							<div class="positionRelative">
								<img width="270" class="media-object xs-width140P borderRadius5" data-src="{{$article->thumb}}" src="{{asset('uploads/settings/'.$settingsInfo->default_img_1)}}" alt="{!! $article->headline !!}" title="{!! $article->headline !!}">
								@if(!empty($article->video_code))
								<span class="pvIconMedium hidden-xs"><i class="fa fa-play"></i></span>
								<span class="pvIconSmall top50P visible-xs"><i class="fa fa-play"></i></span>
								@endif
							</div>
						</div>
						<div class="media-body paddingL8 paddingR8">
							<div class="paddingB0 xs-marginB10">
								<p class="title3 xs-title3 margin0 colorBlack">@if(!empty($article->shoulder))<span class="shoulder">{!! $article->shoulder !!} <span></span> </span>@endif {!! $article->headline !!} @if(!empty($article->hanger))<span class="hanger"> <span></span> {!! $article->hanger !!}</span>@endif</p>
								<p class="summary3 xs-summary3 paddingT10 colorDarkAsh textJustify hidden-xs">{!! $article->summary !!}</p>
							</div>
							<p class="colorDarkAsh time positionAbsolute xs-positionRelative bottom0 marginB5"><i class="fa fa-clock-o icon"></i> {!! $article->publishTime !!} </p>
						</div>
						<a href="{!! $article->url !!}" class="linkOverlay"></a>
					</div>
				</div>
			</div>
			@endforeach

			<!-- load more news -->
			<div class="loadMoreCategoryNews"></div>
		</div>

		<!--load more -->
		<div class="row marginT15 xs-marginT0">
			<div class="col-md-12 col-xs-12 marginT15">
				<div class="text-center"><span data-paginate="1" class="loadMoreButton clickLoadMore">আরও পড়ুন <i class="fa fa-spinner loadingIcon" style="display: none;"></i></span></div>
			</div>
		</div>
		<!-- load more end -->

		@endif
	</div>


	<div class="col-md-4 hidden-xs">
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
@if(!empty($eventInfo))
<!-- ajax load more event news -->
<script type="text/javascript">
	$('.clickLoadMore').click(function(){
		$('.loadingIcon').show();
		var paginate = $(this).data('paginate');
		$(this).data('paginate', parseInt(paginate)+1);
		var url = '{{url("ajax/load/eventnews/")}}/{{$eventInfo->id}}/10/'+paginate+'/20';
		$.get(url, function(data){
			if(data != ''){
				$('.loadingIcon').hide();
				$.each(data, function(key, value){
					$('.loaderDiv1').hide();
					if(value.video_code != null){
						var icon = '<span class="pvIconMedium hidden-xs"><i class="fa fa-play"></i></span><span class="pvIconSmall visible-xs"><i class="fa fa-play"></i></span>';
					}else{
						var icon = '';
					}
					var row = $('<div class="col-md-12 flex-col marginB15 xs-marginB10"><div class="bgWhite mediaItemDiv height100P borderAshB1 paddingB15"><div class="media positionRelative hoverOrange marginT0"><div class="media-left"><div class="positionRelative"><img width="270" class="media-object xs-width140P borderRadius5" src="'+value.thumb+'" alt="'+value.headline+'" title="'+value.headline+'">'+icon+'</div></div><div class="media-body paddingL8 paddingR8"><div class="paddingB0 xs-marginB10"><p class="title3 xs-title3 margin0 colorBlack">'+value.headline+'</p><p class="summary3 xs-summary3 paddingT10 colorDarkAsh hidden-xs textJustify">'+value.summary+'</p></div><p class="colorDarkAsh time positionAbsolute xs-positionRelative bottom0 marginB5"><i class="fa fa-clock-o icon"></i> '+value.publishTime+' </p></div><a href="'+value.url+'" class="linkOverlay"></a></div></div></div>');
					$('.loadMoreCategoryNews').append(row);
				});
			}
		});
	});
</script>
@endif

<!-- ajax load latest news -->
<script type="text/javascript">
	var width = $(window).width();
	if(width > 767){
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
					var row = $('<div class="media"><div class="media-left"><div class="positionRelative"><img width="140" class="media-object" src="'+value.thumb+'" alt="'+value.headline+'" title="'+value.headline+'">'+icon+'</div></div><div class="media-body"><p class="title11">'+value.headline+'</p></div><a href="'+value.url+'" class="linkOverlay"></a></div>');
					$('.ajaxLatestNewsDiv').append(row);
				});				
				$('.latestNewsWidget').show();
			}
		});
	}
</script>

<script type="text/javascript">
	$('.clickSearchEvent').click(function(){
		var eventId = $('.event').val();
		var eventTitle = $('.event').find('option:selected').text();
		eventTitle = eventTitle.replace(/\s+/g, '-');
		if(eventId != ''){
			window.location = '{{url("/")}}/events/'+eventId+'/'+eventTitle;
		}else{
			window.location = '{{url("/events")}}';
		}
	})
</script>
@endpush