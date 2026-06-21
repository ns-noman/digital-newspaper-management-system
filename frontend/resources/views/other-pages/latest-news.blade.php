@extends('layouts.layout')
@push('meta-tag')
<title>{!! !empty($pageInfo) ? $pageInfo->meta_title : 'সর্বশেষ - '.$settingsInfo->title !!}</title>
<meta property="og:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'সর্বশেষ - '.$settingsInfo->title !!}" />
<meta name="twitter:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'সর্বশেষ - '.$settingsInfo->title !!}" />
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
<!-- desktop version start -->
<div class="bgWHite hidden-xs">
	<div class="container latestTabDiv">
		<div class="row">

			<!-- header -->
			<div class="col-sm-12 col-md-12 marginB20 hidden-xs">
				<div class="borderC1B1 paddingB20">
					<h1 class="desktopCategoryTitle"><strong><span class="leftSpan"></span> {!! !empty($pageInfo) && !empty($pageInfo->title) ? $pageInfo->title : 'সর্বশেষ' !!}</strong></h1>

					<ul class="nav nav-pills marginT5">
						<li class="active" role="presentation"><a class="title11 paddingTB5 paddingLR10 borderC1-1 marginR5" href="#news" aria-controls="news" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-newspaper title1_6"></i> সংবাদ</a></li>
						<li role="presentation"><a data-paginate="-1" class="title11 paddingTB5 paddingLR10 borderC1-1 marginR5 clickLatestPhoto latestPhotoTab" href="#photo" aria-controls="photo" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-images title1_6"></i> ছবি</a></li>
						<li role="presentation"><a data-paginate="-1" class="title11 paddingTB5 paddingLR10 borderC1-1 clickLatestVideo latestVideoTab" href="#video" aria-controls="video" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-video title1_6"></i> ভিডিও</a></li>
					</ul>
				</div>
			</div>

			<div class="col-sm-9 col-md-9">
				<div class="tab-content">
					<!-- news -->
					<div role="tabpanel" id="news" class="tab-pane active">
						<div class="row">
							@if(!empty($latestNews) && (count($latestNews)>0))
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="row marginLR-10 desktopFlexRow topThumbNews">
									@for($i=0; $i<=2; $i++)
									@if(!empty($latestNews[$i]))
									@php $article = \App\Models\Helper::processArticleShortly($latestNews[$i], 0); @endphp
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 paddingLR10 borderItem borderC1R1 desktopSectionLead">
										<div class="thumbnail marginB0">
											<div class="positionRelative">
												<a href="{!! $article->url !!}"><img src="{!! $article->thumbMedium !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}"></a>
												@if($article->categoryTitle == 'photos')
												<span class="fa fa-image ppIconMedium"></span>
												@elseif(!empty($article->video_code))
												<span class="fa fa-play pvIconMedium"></span>
												@endif
											</div>
											<div class="caption paddingB0">
												<a class="colorBlack hoverBlue" href="{!! $article->url !!}"><p class="title10 marginT0">{!! $article->fullheadline !!}</p></a>
												@if(!empty($article->summary))
												<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
												@endif
												<p class="desktopTime marginT10"><a href="{!! url($article->categoryTitle) !!}" class="colorBlue"><i class="fa fa-regular fa-tag colorBlue"></i> {!! $article->categoryName !!}</a> <i class="fa fa-grip-lines-vertical marginL5 marginR5"></i> <i class="fa fa-regular fa-clock"></i> {!! $article->publishTime !!}</p>
											</div>
											<!-- <a href="{!! $article->url !!}" class="linkOverlay"></a> -->
										</div>
									</div>
									@endif
									@endfor
								</div>
								<p class="desktopDivider marginT15 marginB5"></p>
							</div>

							<div class="col-sm-12 col-md-12">
								<div class="desktopSectionListMedia loadMoreCategoryNews">
									@for($i=3; $i<=9; $i++)
									@if(!empty($latestNews[$i]))
									@php $article = \App\Models\Helper::processArticleShortly($latestNews[$i], 20); @endphp
									<div class="media positionRelative">
										<div class="media-left">
											<div class="positionRelative">
												<a href="{!! $article->url !!}"><img class="media-object borderRadius5 xs-width120" src="{!! $article->thumbMedium !!}" width="270" alt="{!! $article->headline !!}"></a>
												@if($article->categoryTitle == 'photos')
												<span class="fa fa-image ppIconSmall"></span>
												@elseif(!empty($article->video_code))
												<span class="fa fa-play pvIconSmall"></span>
												@endif
											</div>
										</div>
										<div class="media-body marginL5">
											<a class="colorBlack hoverBlue" href="{!! $article->url !!}"><p class="title10 marginT2">{!! $article->fullheadline !!}</p></a>
											@if(!empty($article->summary))
											<p class="desktopSummary marginT10 hidden-xs">{!! $article->summary !!}</p>
											@endif
											<p class="desktopTime marginT10"><a href="{!! url($article->categoryTitle) !!}" class="colorBlue"><i class="fa fa-regular fa-tag colorBlue"></i> {!! $article->categoryName !!}</a> <i class="fa fa-grip-lines-vertical marginL5 marginR5"></i> <i class="fa fa-regular fa-clock"></i> {!! $article->publishTime !!}</p>
										</div>
										<!-- <a href="{!! $article->url !!}" class="linkOverlay"></a> -->
									</div>
									@endif
									@endfor
								</div>
							</div>
							@else
							<div class="col-sm-12 col-md-12">
								<div class="text-center">No Data Found</div>
							</div>
							@endif
						</div>

						<!--load more -->
						<div class="row marginT30 marginB30">
							<div class="col-md-12 col-xs-12">
								<div class="text-center"><span data-paginate="1" class="loadMoreButton clickLoadMore">আরও পড়ুন <i class="fa fa-spinner loadingIcon" style="display: none;"></i></span></div>
							</div>
						</div>
						<!-- load more end -->
					</div>
					<!-- news -->

					<!-- photo -->
					<div role="tabpanel" id="photo" class="tab-pane">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="row marginLR-10 desktopFlexRow appendLatestPhoto">
								</div>
							</div>
						</div>
						<!--load more -->
						<div class="row marginT30 marginB30">
							<div class="col-md-12 col-xs-12">
								<div class="text-center"><span data-paginate="1" class="loadMoreButton clickLatestPhoto">আরও দেখুন <i class="fa fa-spinner loadingIcon" style="display: none;"></i></span></div>
							</div>
						</div>
					</div>
					<!-- photo -->

					<!-- video -->
					<div role="tabpanel" id="video" class="tab-pane">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="row marginLR-10 desktopFlexRow appendLatestVideo">
								</div>
							</div>
						</div>
						<!--load more -->
						<div class="row marginT30 marginB30">
							<div class="col-md-12 col-xs-12">
								<div class="text-center"><span data-paginate="1" class="loadMoreButton clickLatestVideo">আরও দেখুন <i class="fa fa-spinner loadingIcon" style="display: none;"></i></span></div>
							</div>
						</div>
					</div>
					<!-- video -->

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
<!-- desktop version end -->



<!-- mobile version start -->
<div class="bgWHite visible-xs">
	<div class="container latestTabDiv">
		<div class="row">
			<div class="col-sm-12 col-md-12 paddingLR20 marginB15 paddingT10 marginT10">
				<h1 class="sectionTitle displayInline border0 margin0 marginB0"><strong><span class="leftSpan"></span> {!! !empty($pageInfo) && !empty($pageInfo->title) ? $pageInfo->title : 'সর্বশেষ' !!}</strong></h1>
				<ul class="nav nav-pills marginT10">
					<li class="active" role="presentation"><a class="title1_6 paddingTB5 paddingLR10 borderC1-1 marginR5" href="#news" aria-controls="news" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-newspaper title1_6"></i> সংবাদ</a></li>
					<li role="presentation"><a data-paginate="-1" class="title1_6 paddingTB5 paddingLR10 borderC1-1 marginR5 clickLatestPhoto latestPhotoTab" href="#photo" aria-controls="photo" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-images title1_6"></i> ছবি</a></li>
					<li role="presentation"><a data-paginate="-1" class="title1_6 paddingTB5 paddingLR10 borderC1-1 clickLatestVideo latestVideoTab" href="#video" aria-controls="video" role="tab" data-toggle="tab" aria-expanded="false"><i class="fa fa-video title1_6"></i> ভিডিও</a></li>
				</ul>
			</div>

			<div class="tab-content">
				<!-- news -->
				<div role="tabpanel" id="news" class="tab-pane active">
					@if(!empty($latestNews[0]))
					@php $article = \App\Models\Helper::processArticleShortly($latestNews[0], 0); @endphp
					<div class="col-sm-12 col-md-12 sectionLead padding0 margin0">
						<div class="thumbnail">
							<div class="positionRelative">
								<img src="{!! $article->thumb !!}" class="img-responsive" alt="{!! $article->headline !!}">
								@if($article->categoryTitle == 'photos')
								<span class="fa fa-image ppIconMedium"></span>
								@elseif(!empty($article->video_code))
								<span class="fa fa-play pvIconMedium"></span>
								@endif
							</div>
							<div class="caption">
								<p class="title3"><strong>{!! $article->fullheadline !!}</strong></p>
								<p class="time marginT5"><span class="colorBlue"><i class="fa fa-regular fa-tag colorBlue"></i> {!! $article->categoryName !!}</span> <i class="fa fa-grip-lines-vertical marginL5 marginR5"></i> <i class="fa fa-regular fa-clock"></i> {!! $article->publishTime !!}</p>
							</div>
							<a href="{!! $article->url !!}" class="linkOverlay"></a>
						</div>
					</div>
					@endif
					<div class="col-sm-12 col-md-12 paddingLR0 marginB5"><div class="borderC1T1"></div></div>


					@if(!empty($latestNews) && (count($latestNews)>0))
					<div class="col-sm-12 col-md-12 paddingLR20 marginT0">
						<div class="sectionListMedia loadMoreCategoryNewsMobile borderC1B1">
							@for($i=1; $i<=9; $i++)
							@if(!empty($latestNews[$i]))
							@php $article = \App\Models\Helper::processArticleShortly($latestNews[$i], 0); @endphp
							<div class="media positionRelative">
								<div class="media-left paddingR5">
									<div class="positionRelative">
										<img class="media-object" src="{!! $article->thumbSmall !!}" width="140" alt="{!! $article->headline !!}">
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconSmall"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconSmall"></span>
										@endif
									</div>
								</div>
								<div class="media-body">
									<p class="time marginL5 marginB5"><span class="colorBlue"><i class="fa fa-regular fa-tag colorBlue"></i> {!! $article->categoryName !!}</span></p>
									<p class="xs-title marginL5 marginB0">{!! $article->fullheadline !!}</p>
									<p class="time marginT5 marginL5"><i class="fa fa-regular fa-clock"></i> {!! $article->publishTime !!}</p>
								</div>
								<a href="{!! $article->url !!}" class="linkOverlay"></a>
							</div>
							@endif
							@endfor
						</div>
					</div>

					<!-- load more button -->
					<div class="text-center marginT20">
						<span data-paginate="1" class="loadMoreButtonMobile clickLoadMoreMobile">আরও পড়ুন <i class="fa fa-spinner loadingIcon" style="display: none;"></i></span>
					</div>
					<!-- load more button -->
					@endif
				</div>
				<!-- news -->

				<!-- photo -->
				<div role="tabpanel" id="photo" class="tab-pane">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="row marginLR-10 desktopFlexRow appendLatestPhoto">
								</div>
							</div>
						</div>
						<!--load more -->
						<div class="row marginT30 marginB30">
							<div class="col-md-12 col-xs-12">
								<div class="text-center"><span data-paginate="1" class="loadMoreButton clickLatestPhoto">আরও দেখুন <i class="fa fa-spinner loadingIcon" style="display: none;"></i></span></div>
							</div>
						</div>
					</div>
				</div>
				<!-- photo -->

				<!-- video -->
				<div role="tabpanel" id="video" class="tab-pane">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="row marginLR-10 desktopFlexRow appendLatestVideo">
								</div>
							</div>
						</div>
						<!--load more -->
						<div class="row marginT30 marginB30">
							<div class="col-md-12 col-xs-12">
								<div class="text-center"><span data-paginate="1" class="loadMoreButton clickLatestVideo">আরও দেখুন <i class="fa fa-spinner loadingIcon" style="display: none;"></i></span></div>
							</div>
						</div>
					</div>
				</div>
				<!-- video -->

			</div>
		</div>
	</div>
</div>
<!-- mobile version end -->

<!-- view modal -->
<div class="modal fade viewModal" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header" style="padding-bottom: 5px">
				<p class="title11 margin0">ছবি <a class="downloadPreviewPhoto marginL10" href="" download="download"><i class="fa fa-download title1_6"></i></a>
					<button type="button" class="close popupModalClose hoverBlack popupModalAdCloseButton pull-right title10" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</p>
			</div>
			<div class="modal-body">
				<div class="previewModalPhoto"></div>
			</div>
		</div>
	</div>
</div>


@endsection

@push('js')
<!-- desktop ajax load more latest news -->
<script type="text/javascript">
	$('.clickLoadMore').click(function(){
		$('.loadingIcon').show();
		var paginate = $(this).data('paginate');
		$(this).data('paginate', parseInt(paginate)+1);
		var url = '{{url("ajax/load/latestnews/")}}/10/'+paginate+'/20';
		$.get(url, function(data){
			if(data != ''){
				$('.loadingIcon').hide();
				$.each(data, function(key, value){
					$('.loaderDiv1').hide();
					if(value.categoryTitle == 'photos'){
						var icon = '<span class="fa fa-image ppIconMedium"></span>';
					}else if(value.video_code != null){
						var icon = '<span class="fa fa-play pvIconMedium"></span>';
					}else{
						var icon = '';
					}
					var row = $('<div class="media positionRelative"><div class="media-left paddingL5"><div class="positionRelative"><a href="'+value.url+'"><img class="media-object borderRadius5 xs-width120" src="'+value.thumbMedium+'" width="270" alt="'+value.headline+'"></a>'+icon+'</div></div><div class="media-body"><a class="colorBlack hoverBlue" href="'+value.url+'"><p class="title10 marginT2">'+value.fullheadline+'</p></a><p class="desktopSummary marginT10 hidden-xs">'+value.summary+'</p><p class="desktopTime marginT10"><a href="'+value.categoryTitle+'" class="colorBlue"><i class="fa fa-regular fa-tag colorBlue"></i> '+value.categoryName+'</a> <i class="fa fa-grip-lines-vertical marginL5 marginR5"></i> <i class="fa fa-regular fa-clock"></i> '+value.publishTime+'</p></div></div>');
					$('.loadMoreCategoryNews').append(row);
				});
			}
		});
	});
</script>

<!-- mobile ajax load more latest news -->
<script type="text/javascript">
	$('.clickLoadMoreMobile').click(function(){
		$('.loadingIcon').show();
		var paginate = $(this).data('paginate');
		$(this).data('paginate', parseInt(paginate)+1);
		var url = '{{url("ajax/load/latestnews/")}}/10/'+paginate+'/0';
		$.get(url, function(data){
			if(data != ''){
				$('.loadingIcon').hide();
				$.each(data, function(key, value){
					$('.loaderDiv1').hide();
					if(value.categoryTitle == 'photos'){
						var icon = '<span class="fa fa-image ppIconSmall"></span>';
					}else if(value.video_code != null){
						var icon = '<span class="fa fa-play pvIconSmall"></span>';
					}else{
						var icon = '';
					}
					var row = $('<div class="media positionRelative"><div class="media-left paddingR5"><div class="positionRelative"><img class="media-object" src="'+value.thumbSmall+'" width="140" alt="'+value.headline+'">'+icon+'</div></div><div class="media-body"><p class="time marginL5 marginB5"><span class="colorBlue"><i class="fa fa-regular fa-tag colorBlue"></i> '+value.categoryName+'</span></p><p class="xs-title marginL5 marginB0">'+value.fullheadline+'</p><p class="time marginT5 marginL5"><i class="fa fa-regular fa-clock"></i> '+value.publishTime+'</p></div><a href="'+value.url+'" class="linkOverlay"></a></div>');
					$('.loadMoreCategoryNewsMobile').append(row);
				});
			}
		});
	});
</script>

<script type="text/javascript">
	$('.latestTabDiv').on('click', '.clickLatestPhoto', function(){
		$('.latestPhotoTab').removeClass('clickLatestPhoto');
		$('.loadingIcon').show();
		var paginate = $(this).data('paginate');
		$(this).data('paginate', parseInt(paginate)+1);
		var url = '{{url("ajax/load/latestphotos/")}}/9/'+paginate;
		$.get(url, function(data){
			if(data != ''){
				$('.loadingIcon').hide();
				$.each(data, function(key, value){
					$('.loaderDiv1').hide();

					var publishDateTime = '';
					if(value.publishDateTime != ''){
						var publishDateTime = '<div class="caption paddingB0 borderC1-1 borderBRadius5" style="padding: 5px !important"><p class="title11 xs-title1_6 marginT0 colorBlack">'+value.publishDateTime+' <a class="pull-right" href="'+value.photoLink+'" title="'+value.image+'" download="download"><i class="fa fa-download title1_6"></i></a></p></div>';
					}

					var row = $('<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 paddingLR10 desktopSectionLead"><div class="thumbnail marginB15"><div class="positionRelative"><img src="'+value.photoLink+'" class="img-responsive borderTRadius5" alt="'+value.image_caption+'"></div>'+publishDateTime+'</div><a data-toggle="modal" href="#viewModal" class="linkOverlay clickViewModal" data-image="'+value.photoLink+'" ></a></div>');
					$('.appendLatestPhoto').append(row);
				});
			}
		});
	});
</script>

<script type="text/javascript">
	$('.appendLatestPhoto').on('click', '.clickViewModal', function(){
		var photoLink = $(this).data('image');
		$('.viewModal .modal-body .previewModalPhoto').html('<img src="'+photoLink+'" class="img-responsive" />');
		$('.viewModal .modal-header .downloadPreviewPhoto').attr('href', photoLink);
	});
</script>

<script type="text/javascript">
	$('.latestTabDiv').on('click', '.clickLatestVideo', function(){
		$('.latestVideoTab').removeClass('clickLatestVideo');
		$('.loadingIcon').show();
		var paginate = $(this).data('paginate');
		$(this).data('paginate', parseInt(paginate)+1);
		var url = '{{url("ajax/load/latestvideos/")}}/9/'+paginate;
		$.get(url, function(data){
			if(data != ''){
				$('.loadingIcon').hide();
				$.each(data, function(key, value){
					$('.loaderDiv1').hide();

					var publishDateTime = '';
					if(value.publishDateTime != ''){
						var publishDateTime = '<div class="caption paddingB0 borderC1-1 borderBRadius5" style="padding: 5px !important"><p class="title11 xs-title1_6 marginT0 colorBlack">'+value.publishDateTime+'</p></div>';
					}

					var row = $('<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 paddingLR10 desktopSectionLead"><div class="thumbnail marginB15"><div class="positionRelative"><img src="'+value.thumb+'" class="img-responsive borderTRadius5" alt="'+value.headline+'"><span class="fa fa-play pvIconMedium"></span></div>'+publishDateTime+'</div><a href="'+value.url+'" class="linkOverlay" target="_blank"></a></div>');
					$('.appendLatestVideo').append(row);
				});
			}
		});
	});
</script>
@endpush