@extends('layouts.layout')
@push('meta-tag')
<title>{!! !empty($pageInfo) ? $pageInfo->meta_title : (!empty($categoryInfo->meta_title) ? $categoryInfo->meta_title : $categoryInfo->display_name.' - '.$settingsInfo->newspaper_name) !!}</title>
<meta property="og:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : (!empty($categoryInfo->meta_title) ? $categoryInfo->meta_title : $categoryInfo->display_name.' - '.$settingsInfo->newspaper_name) !!}" />
<meta property="og:description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : (!empty($categoryInfo->meta_description) ? $categoryInfo->meta_description : '') !!}" />
<meta name="description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : (!empty($categoryInfo->meta_description) ? $categoryInfo->meta_description : '') !!}" />
<meta name="twitter:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : (!empty($categoryInfo->meta_title) ? $categoryInfo->meta_title : $categoryInfo->display_name.' - '.$settingsInfo->newspaper_name) !!}" />
<meta name="twitter:description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : (!empty($categoryInfo->meta_description) ? $categoryInfo->meta_description : '') !!}" />
<meta name="keywords" content="{!! !empty($pageInfo) ? $pageInfo->meta_keywords : (!empty($categoryInfo->meta_keywords) ? $categoryInfo->meta_keywords : '') !!}" />
<meta property="og:image" content="{!! !empty($pageInfo) && !empty($pageInfo->meta_image_src) ? $pageInfo->meta_image_src : asset('uploads/settings/'.$settingsInfo->default_img_1) !!}" />
<meta name="twitter:image" content="{!! !empty($pageInfo) && !empty($pageInfo->meta_image_src) ? $pageInfo->meta_image_src : asset('uploads/settings/'.$settingsInfo->default_img_1) !!}" />
<meta name="robots" content="index, follow" />
{!! !empty($pageInfo) ? $pageInfo->header_code : $categoryInfo->header_code !!}
@endpush

@section('content')

<!-- desktop version start -->
<div class="bgWHite hidden-xs">
	
	<!-- category header -->
	<div style="background-color: #a84040;margin-top: -30px;padding: 20px 0px">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-12">
					@if(!empty($_GET['date']))
					<span class="desktopCategoryTitle colorWhite">{!! App\Models\Helper::GetBangla(date('d M Y', strtotime($_GET['date']))) !!} <i style="font-size: 2.3rem;" class="fa fa-grip-lines-vertical"></i>&nbsp;</span>
					@endif

					@if(!empty($parentCategoryInfo))
					<span class="desktopCategoryTitle"><a class="colorWhite hoverBlack" aria-label="{!! $parentCategoryInfo->display_name !!}" href="{!! url($parentCategoryInfo->title) !!}">{!! $parentCategoryInfo->display_name !!}</a> <i class="fa fa-caret-right" style="font-size: 1.8rem;margin-right: 5px"></i></span>
					@endif
					<p class="desktopCategoryTitle"><a class="colorWhite hoverBlack" aria-label="{!! $categoryInfo->display_name !!}" href="{!! url($categoryInfo->title) !!}">{!! $categoryInfo->display_name !!}</a></p>
					<!-- subcategories -->
					@if(!empty($subCategories) && (count($subCategories)>0))
					<div class="desktopSubCategoryDiv">
						<ul>
							@foreach($subCategories as $key => $subCat)
							<li><i class="fa fa-circle"></i> <p><a class="colorWhite hoverBlack" aria-label="{!! $subCat->display_name !!}" href="{!! url($subCat->title) !!}{!! Request::has('date') ? '?date='.Request::query('date') : '' !!}">{!! $subCat->display_name !!}</a></p></li>
							@endforeach
						</ul>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
	<!-- category header end -->


	<div class="container marginT20">
		<div class="row">

			<!-- category articles -->
			@if(!empty($parentCategoryInfo))
			<div class="col-sm-9 col-md-9">
				<div class="row">
					@if(!empty($categoryArticles) && (count($categoryArticles)>0))
					<div class="col-sm-12 col-md-12 marginT40">
						<div class="row desktopFlexRow marginLR-10">
							<div class="col-sm-12 col-md-12 paddingLR10">
								<p class="desktopSectionTitle marginB15"><a aria-label="{!! $categoryArticles[0]->display_name !!}" href="{!! url($categoryArticles[0]->title) !!}">{!! $categoryArticles[0]->display_name !!}</a> <a href="{!! url($categoryArticles[0]->title) !!}" class="float-right"><i class="fa fa-angle-double-right title1_6"></i></a> <span class="bottomMarked"></span></p>
							</div>

							<div class="col-sm-12 col-md-12 paddingLR10">
								<div class="desktopSectionListMedia listItemLastBB0 marginT-15 loadMoreCategoryNewsDesktop">
									@for($i=0; $i<=8; $i++)
									@if(!empty($categoryArticles[$i]))
									@php $article = \App\Models\Helper::processArticleShortly($categoryArticles[$i], 20); @endphp
									<div class="media positionRelative">
										<div class="media-left">
											<div class="positionRelative">
												<img class="media-object borderRadius5" src="{!! $article->thumbMedium !!}" width="250" alt="{!! $article->headline !!}">
												@if($article->categoryTitle == 'photos')
												<span class="fa fa-image ppIconSmall"></span>
												@elseif(!empty($article->video_code))
												<span class="fa fa-play pvIconSmall"></span>
												@endif
											</div>
										</div>
										<div class="media-body marginL5">
											<p class="title10 marginT2">{!! $article->fullheadline !!}</p>
											@if(!empty($article->summary))
											<p class="desktopSummary marginT10">{!! $article->summary !!}</p>
											@endif
											<p class="desktopTime marginT10"><i class="fa fa-regular fa-clock"></i> {!! $article->publishTime !!}</p>
										</div>
										<a href="{!! $article->url !!}" class="linkOverlay"></a>
									</div>
									@endif
									@endfor
								</div>
							</div>
						</div>
					</div>

					<div class="col-sm-12 col-md-12 paddingLR20 marginB15 marginT20">
						<!-- load more button -->
						<div class="text-center marginT15">
							<span data-paginate="1" class="loadMoreButton clickLoadMoreDesktop">আরও পড়ুন <i class="fa fa-spinner loadingIcon" style="display: none;"></i></span>
						</div>
						<!-- load more button -->
					</div>
					@endif
				</div>
			</div>

			@else
			<!-- sub category articles -->
			@if(!empty($subCategoryArticles) && (count($subCategoryArticles)>0))
			<div class="col-sm-9 col-md-9">
				<div class="row">
					@foreach($subCategoryArticles as $key => $subCatArticleList)
					@if(!empty($subCatArticleList) && (count($subCatArticleList)>0))
					<div class="col-sm-12 col-md-12 marginT40">
						<div class="row desktopFlexRow marginLR-10">
							<div class="col-sm-12 col-md-12 paddingLR10">
								<p class="desktopSectionTitle marginB15"><a aria-label="{!! $subCatArticleList[0]->display_name !!}" href="{!! url($subCatArticleList[0]->title) !!}{!! Request::has('date') ? '?date='.Request::query('date') : '' !!}">{!! $subCatArticleList[0]->display_name !!}</a> <a href="{!! url($subCatArticleList[0]->title) !!}{!! Request::has('date') ? '?date='.Request::query('date') : '' !!}" class="float-right"><i class="fa fa-angle-double-right title1_6"></i></a> <span class="bottomMarked"></span></p>
							</div>

							@if(!empty($subCatArticleList[0]))
							@php $article = \App\Models\Helper::processArticleShortly($subCatArticleList[0], 0); @endphp
							<div class="col-sm-6 col-md-6 desktopSectionLead paddingLR10">
								<div class="thumbnail marginB0">
									<div class="positionRelative">
										<img src="{!! $article->thumb !!}" class="img-responsive borderRadius5" alt="{!! $article->headline !!}">
										@if($article->categoryTitle == 'photos')
										<span class="fa fa-image ppIconMedium"></span>
										@elseif(!empty($article->video_code))
										<span class="fa fa-play pvIconMedium"></span>
										@endif
									</div>
									<div class="caption">
										<p class="title10 marginT0">{!! $article->fullheadline !!}</p>
										@if(!empty($article->summary))
										<p class="desktopSummary marginB5">{!! $article->summary !!}</p>
										@endif
										<p class="desktopTime"><i class="fa fa-regular fa-clock"></i> {!! $article->publishTime !!}</p>
									</div>
									<a href="{!! $article->url !!}" class="linkOverlay"></a>
								</div>
							</div>
							@endif

							<div class="col-sm-6 col-md-6">
								<div class="desktopSectionListMedia listItemLastBB0 marginT-15">
									@for($i=1; $i<=3; $i++)
									@if(!empty($subCatArticleList[$i]))
									@php $article = \App\Models\Helper::processArticleShortly($subCatArticleList[$i], 0); @endphp
									<div class="media positionRelative">
										<div class="media-left">
											<div class="positionRelative">
												<img class="media-object borderRadius5" src="{!! $article->thumbMedium !!}" width="140" alt="{!! $article->headline !!}">
												@if($article->categoryTitle == 'photos')
												<span class="fa fa-image ppIconSmall"></span>
												@elseif(!empty($article->video_code))
												<span class="fa fa-play pvIconSmall"></span>
												@endif
											</div>
										</div>
										<div class="media-body marginL5">
											<p class="title11">{!! $article->fullheadline !!}</p>
											@if(!empty($article->summary))
											<p class="desktopSummary marginT10">{!! $article->summary !!}</p>
											@endif
											<p class="desktopTime"><i class="fa fa-regular fa-clock"></i> {!! $article->publishTime !!}</p>
										</div>
										<a href="{!! $article->url !!}" class="linkOverlay"></a>
									</div>
									@endif
									@endfor
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 paddingLR20 marginB15"><div class="borderC1T1 text-center"><span class="desktopCatReadMore"><a href="{!! url($subCatArticleList[0]->title) !!}">আরও</a></span></div></div>
					@endif
					@endforeach
				</div>
			</div>
			@endif
			@endif

			<!-- first sidebar -->
			<div class="col-sm-3 col-md-3 marginT70">
				<!-- archive -->
				<div class="row marginT5">
					<div class="col-sm-12 col-md-12 marginB20">
						<div class="marginCenter w300 borderRadius5" style="box-shadow: 0px 0px 5px 2px #ccc;">
							<div class="desktopLocationDiv" style="position: relative;">
								<p style="background-color: #ed1c24;padding: 8px;font-size: 2.3rem;color: white;border-top-left-radius: 5px;border-top-right-radius: 5px;margin-bottom: 0px"><span aria-label="আর্কাইভ" class="colorWhite textDecorationNone">পত্রিকা আর্কাইভ</span></p>
								<div style="padding: 15px;">
									<div class="row">
										<div class="col-sm-6 col-md-6 paddingLR5">
											<div class="marginL10">
												<select class="form-control selectDay archiveDays">
													<option value="">দিন</option>
												</select>
											</div>
										</div>
										<div class="col-sm-6 col-md-6 paddingLR5">
											<div class="marginR10">
												<select class="form-control selectMonth archiveMonths">
													<option value="">মাস</option>
												</select>
											</div>
										</div>
										<div class="col-sm-12 col-md-12 marginT15">
											<div>
												<select class="form-control selecYear archiveYears">
													<option value="">বছর</option>
												</select>
											</div>
										</div>
										<div class="col-sm-12 col-md-12 marginT15">
											<div>
												<button type="button" class="btn btn-block clickSearchArchive" style="background-color: #344054">অনুসন্ধান</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- archive end -->

				<!-- ad -->
				<!-- <div class="row">
					<div class="col-sm-12 col-md-12 marginB20">
						<div class="adDiv w300 borderRadius5 overflowHidden">
							<a href="" target="_blank"><img src="{!! asset('uploads/advertisements/300x250-2.jpg') !!}" align="Ad" class="img-responsive"></a>
						</div>
					</div>
				</div> -->
				<!-- ad -->

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
	<div class="container paddingT10">
		<div class="row">
			<!-- header -->
			<div class="col-sm-12 col-md-12 paddingLR20 marginB15">
				@if(!empty($_GET['date']))
				<span class="sectionTitle border0 displayInline"><strong>{!! App\Models\Helper::GetBangla(date('d M Y', strtotime($_GET['date']))) !!} <i class="fa fa-grip-lines-vertical title1_8"></i>&nbsp;</strong></span>
				@endif
				@if(!empty($parentCategoryInfo))
				<span class="sectionTitle border0 displayInline"><a class="color1" aria-label="{!! $parentCategoryInfo->display_name !!}" href="{!! url($parentCategoryInfo->title) !!}"><strong>{!! $parentCategoryInfo->display_name !!}</strong></a> <i class="fa fa-caret-right" style="font-size: 1.8rem;margin-right: 5px"></i></span>
				@endif
				<p class="sectionTitle border0 margin0 marginB0 displayInline"><a aria-label="{!! $categoryInfo->display_name !!}" href="{!! url($categoryInfo->title) !!}"><strong>{!! $categoryInfo->display_name !!}</strong></a></p>
				<!-- subcategories -->
				@if(!empty($subCategories) && (count($subCategories)>0))
				<div class="subCategoryDiv">
					<ul>
						@foreach($subCategories as $key => $subCat)
						<li><i class="fa fa-circle"></i> <p><a aria-label="{!! $subCat->display_name !!}" href="{!! url($subCat->title) !!}{!! Request::has('date') ? '?date='.Request::query('date') : '' !!}">{!! $subCat->display_name !!}</a></p></li>
						@endforeach
					</ul>
				</div>
				@endif
			</div>

			@if(!empty($parentCategoryInfo))
			<!-- lead news -->
			@if(!empty($categoryArticles[0]))
			@php $article = \App\Models\Helper::processArticleShortly($categoryArticles[0], 0); @endphp
			<div class="col-sm-12 col-md-12 sectionLead padding0 margin0">
				<div class="thumbnail">
					<div class="positionRelative">
						<img src="{!! $article->thumb !!}" class="img-responsive" alt="{!! $article->headline !!}">
						@if($article->categoryTitle == 'photos')
						<span class="fa fa-image ppIconLarge"></span>
						@elseif(!empty($article->video_code))
						<span class="fa fa-play pvIconLarge"></span>
						@endif
					</div>
					<div class="caption">
						<p class="title3"><strong>{!! $article->fullheadline !!}</strong></p>
						<p class="time"><i class="fa fa-regular fa-clock"></i> {!! $article->publishTime !!}</p>
					</div>
					<a href="{!! $article->url !!}" class="linkOverlay"></a>
				</div>
			</div>
			@endif
			<div class="col-sm-12 col-md-12 paddingLR0 marginB5"><div class="borderC1T1"></div></div>


			@if(!empty($categoryArticles) && (count($categoryArticles)>0))
			<!-- list news -->
			<div class="col-sm-12 col-md-12 paddingLR20">
				<div class="sectionListMedia">
					@for($i=1; $i<=9; $i++)
					@if(!empty($categoryArticles[$i]))
					@php $article = \App\Models\Helper::processArticleShortly($categoryArticles[$i], 0); @endphp
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
							<p class="xs-title marginL5">{!! $article->fullheadline !!}</p>
							<p class="time marginL5"><i class="fa fa-regular fa-clock"></i> {!! $article->publishTime !!}</p>
						</div>
						<a aria-label="{!! $article->headline !!}" href="{!! $article->url !!}" class="linkOverlay"></a>
					</div>
					@endif
					@endfor

					<!-- load more news -->
					<div class="loadMoreCategoryNewsMobile"></div>
					<!-- load more news end -->

				</div>
			</div>


			<!-- load more button -->
			<div class="text-center marginT30">
				<span data-paginate="1" class="loadMoreButtonMobile clickLoadMoreMobile">{!! $categoryInfo->title == 'videos' || $categoryInfo->title == 'photos' ? 'আরও দেখুন' : 'আরও পড়ুন' !!} <i class="fa fa-spinner loadingIcon" style="display: none;"></i></span>
			</div>
			<!-- load more button -->
			@endif
			


			@else
			<!-- subcategory news -->
			@if(!empty($subCategoryArticles) && (count($subCategoryArticles)>0))
			@foreach($subCategoryArticles as $key => $subCatArticleList)
			@if(!empty($subCatArticleList) && (count($subCatArticleList)>0))
			<div class="marginT30">
				<div class="col-sm-12 col-md-12 paddingLR10">
					<p class="sectionTitle marginB15"><a aria-label="{!! $subCatArticleList[0]->display_name !!}" href="{!! url($subCatArticleList[0]->title) !!}{!! Request::has('date') ? '?date='.Request::query('date') : '' !!}">{!! $subCatArticleList[0]->display_name !!}</a> <a href="{!! url($subCatArticleList[0]->title) !!}{!! Request::has('date') ? '?date='.Request::query('date') : '' !!}" class="float-right"><i class="fa fa-angle-double-right title1_4"></i></a> <span class="bottomMarked"></span></p>
				</div>

				@if(!empty($subCatArticleList[0]))
				@php $article = \App\Models\Helper::processArticleShortly($subCatArticleList[0], 0); @endphp
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
							<p class="time"><i class="fa fa-regular fa-clock"></i> {!! $article->publishTime !!}</p>
						</div>
						<a href="{!! $article->url !!}" class="linkOverlay"></a>
					</div>
				</div>
				@endif
				<div class="col-sm-12 col-md-12 paddingLR0 marginB5"><div class="borderC1T1"></div></div>

				<div class="col-sm-12 col-md-12 paddingLR20">
					<div class="sectionListMedia">
						@for($i=1; $i<=4; $i++)
						@if(!empty($subCatArticleList[$i]))
						@php $article = \App\Models\Helper::processArticleShortly($subCatArticleList[$i], 0); @endphp
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
								<p class="xs-title marginL5">{!! $article->fullheadline !!}</p>
								<p class="time marginL5"><i class="fa fa-regular fa-clock"></i> {!! $article->publishTime !!}</p>
							</div>
							<a aria-label="{!! $article->headline !!}" href="{!! $article->url !!}" class="linkOverlay"></a>
						</div>
						@endif
						@endfor
					</div>
				</div>
				<div class="col-sm-12 col-md-12 paddingLR20 marginB15 marginT10"><div class="borderC1T1 text-center"><span class="catReadMore"><a href="{!! url($subCatArticleList[0]->title) !!}">আরও</a></span></div></div>
			</div>
			@endif
			@endforeach
			@endif
			<!-- subcategory news end -->
			@endif

		</div>
	</div>
</div>
<!-- mobile version end -->

@endsection

@push('js')
<!-- search archive -->
<script type="text/javascript">
	$('.clickSearchArchive').click(function(){
		var archiveDay = $('.selectDay').val();
		var archiveMonth = $('.selectMonth').val();
		var archiveYear = $('.selecYear').val();
		if(archiveDay == ''){
		}else if(archiveMonth == ''){
		}else if(archiveYear == ''){
		}else{
			var date = archiveYear+'-'+archiveMonth+'-'+archiveDay;
			window.location = "{{Request::url()}}?search=yes&date="+date;
		}
	});
</script>

<!-- desktop ajax load more category news -->
<script type="text/javascript">
	$('.clickLoadMoreDesktop').click(function(){
		$('.loadingIcon').show();
		var paginate = $(this).data('paginate');
		$(this).data('paginate', parseInt(paginate)+1);
		var url = '{{url("ajax/load/categorynews/")}}/{{$categoryInfo->id}}/9/'+paginate+'/20'+'{!! Request::has('date') ? '?date='.Request::query('date') : '' !!}';
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
					var row = $('<div class="media positionRelative"><div class="media-left paddingL5"><div class="positionRelative"><img class="media-object borderRadius5" src="'+value.thumbSmall+'" width="250" alt="'+value.headline+'">'+icon+'</div></div><div class="media-body"><p class="title10 marginT2">'+value.fullheadline+'</p><p class="desktopSummary marginT10">'+value.summary+'</p><p class="desktopTime marginT10"><i class="fa fa-regular fa-clock"></i> '+value.publishTime+'</p></div><a aria-label="'+value.headline+'" href="'+value.url+'" class="linkOverlay"></a></div>');

					$('.loadMoreCategoryNewsDesktop').append(row);
				});
			}
		});
	});
</script>

<!-- mobile ajax load more category news -->
<script type="text/javascript">
	$('.clickLoadMoreMobile').click(function(){
		$('.loadingIcon').show();
		var paginate = $(this).data('paginate');
		$(this).data('paginate', parseInt(paginate)+1);
		var url = '{{url("ajax/load/categorynews/")}}/{{$categoryInfo->id}}/9/'+paginate+'/0'+'{!! Request::has('date') ? '?date='.Request::query('date') : '' !!}';
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
					var row = $('<div class="media positionRelative"><div class="media-left paddingR5"><div class="positionRelative"><img class="media-object" src="'+value.thumbSmall+'" width="140" alt="'+value.headline+'">'+icon+'</div></div><div class="media-body"><p class="xs-title marginL5">'+value.headline+'</p><p class="time marginL5"><i class="fa fa-regular fa-clock"></i> '+value.publishTime+'</p></div><a aria-label="'+value.headline+'" href="'+value.url+'" class="linkOverlay"></a></div>');
					$('.loadMoreCategoryNewsMobile').append(row);
				});
			}
		});
	});
</script>
@endpush