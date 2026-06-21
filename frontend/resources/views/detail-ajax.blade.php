<!-- desktop version start -->
<div class="bgWHite hidden-xs">
	<div class="hidden-print articleDividerDiv"><p><i class="fa fa-caret-down" style="margin-top: -17px;font-size: 3.5rem;color: #017ac3;"></i></p></div>

	<!-- article reached -->
	<div class="articleReached{{$detailCount}}" data-url="{{$articleDetail->url}}"></div>
	
	<div class="container">
		<div class="row">

			<!-- title & time section -->
			<div class="col-md-12 col-lg-12">
				<!-- title section -->
				<div class="marginB20">
					<p class="desktopDetailCat marginB15"><a aria-label="{!! $articleDetail->categoryName !!}" href="{!! url($articleDetail->categoryTitle) !!}"><strong>{!! $articleDetail->categoryName !!}</strong></a></p>
					@if(!empty($articleDetail->shoulder))
					<p class="desktopDetailShoulder marginT25">{!! $articleDetail->shoulder !!}</p>
					@endif
					<h1 class="desktopDetailHeadline marginT0"><strong>{!! $articleDetail->headline !!}</strong></h1>
					@if(!empty($articleDetail->hanger))
					<p class="desktopDetailHanger">{!! $articleDetail->hanger !!}</p>
					@endif
				</div>

				<!-- time section -->
				<div class="row">
					<div class="col-sm-12 col-md-12 marginT10">
						<div class="displayInlineBlock" style="border-right: 3px solid #edebeb;padding-right: 20px;">
							<!-- multiple author -->
							@if(!empty($articleDetail->authors) && count($articleDetail->authors)>1)
							@foreach($articleDetail->authors as $key => $authorInfo)
							<p class="desktopDetailReporter borderC1-1 borderRadius5 paddingTB3 paddingLR5 marginR5 marginB5"><a href="{!! $authorInfo->url !!}" class="textDecorationNone colorBlue hoverBlack"><img src="{!! $authorInfo->author_photo_src !!}" class="img-responsive borderRadius50P displayInlineBlock" width="25" alt="{!! $authorInfo->author_name !!}"> <span class="displayInlineBlock verticalAlignMiddle">{!! $authorInfo->author_name !!}</span></a></p>
							@endforeach
							<p class="desktopDetailPTime color1 marginT5">প্রকাশ: {!! $articleDetail->publishDateTime !!}
								@if(($articleDetail->show_updatetime == 1) && !empty($articleDetail->updateDateTime))
								<span><i class="fa fa-grip-lines-vertical title1_4"></i> আপডেট: {!! $articleDetail->updateDateTime !!}</span>
								@endif
							</p>
							@if(!empty($articleDetail->news_type) && ($articleDetail->news_type == 2))
							<p class="desktopDetailPTime color1">প্রিন্ট সংস্করণ</p>
							@endif

							<!-- single author -->
							@elseif(!empty($articleDetail->authors) && count($articleDetail->authors) == 1)
							@php $authorInfo = $articleDetail->authors[0]; @endphp
							<div class="desktopDetailAuthorDiv">
								<a href="{!! $authorInfo->url !!}"><img src="{!! $authorInfo->author_photo_src !!}" class="img-responsive borderRadius50P" width="50"  alt="{!! $authorInfo->author_name !!}"></a>
							</div>
							<div class="displayInlineBlock">
								<p class="desktopDetailReporter"><a href="{!! $authorInfo->url !!}" class="textDecorationNone colorBlue hoverBlack">{!! $authorInfo->author_name !!}</a></p>
								<p class="desktopDetailPTime color1">প্রকাশ: {!! $articleDetail->publishDateTime !!}
									@if(($articleDetail->show_updatetime == 1) && !empty($articleDetail->updateDateTime))
									<span><i class="fa fa-grip-lines-vertical title1_4"></i> আপডেট: {!! $articleDetail->updateDateTime !!}</span>
									@endif
								</p>
								@if(!empty($articleDetail->news_type) && ($articleDetail->news_type == 2))
								<p class="desktopDetailPTime color1">প্রিন্ট সংস্করণ</p>
								@endif
							</div>

							<!-- no author -->
							@else
							<div class="desktopDetailAuthorDiv">
								<img src="{!! env('UploadsLink').'uploads/settings/'.$settingsInfo->icon_2 !!}" class="img-responsive borderRadius50P" width="50" alt="Icon">
							</div>
							<div class="displayInlineBlock">
								@if(!empty($articleDetail->reporter))
								<p class="desktopDetailReporter">{!! $articleDetail->reporter !!}</p>
								@endif
								<p class="desktopDetailPTime color1">প্রকাশ: {!! $articleDetail->publishDateTime !!}
									@if(($articleDetail->show_updatetime == 1) && !empty($articleDetail->updateDateTime))
									<span><i class="fa fa-grip-lines-vertical title1_4"></i> আপডেট: {!! $articleDetail->updateDateTime !!}</span>
									@endif
								</p>
								@if(!empty($articleDetail->news_type) && ($articleDetail->news_type == 2))
								<p class="desktopDetailPTime color1">প্রিন্ট সংস্করণ</p>
								@endif
							</div>
							@endif
						</div>

						<div class="hidden-print text-left displayInlineBlock" style="vertical-align: top;margin-top: 10px;margin-left: 20px;">
							<!-- sharethis -->
							<div class="sharethis-inline-share-buttons st-left displayInline" style="text-align: left;" data-url="{!! $articleDetail->url !!}"></div>
							<div class="shareCustomButton displayInline">
								<span>অ <i class="fa fa-minus clickZoomOut{{$detailCount}}" font-size="2" line-height="3" title="Zoom Out"></i> <i class="fa fa-plus clickZoomIn{{$detailCount}}" font-size="2" line-height="3" title="Zoom In"></i></span>
							</div>
						</div>
					</div>
				</div>

				<p class="desktopDivider"></p>
			</div>

			<!-- news section -->
			<div class="col-md-9 col-lg-9">

				<!-- video section -->
				@if(!empty($articleDetail->video_code))
				<div class="desktopDetailVideo hidden-print">
					<div>{!! $articleDetail->video_code !!}</div>
				</div>
				@endif

				<!-- photo section -->
				@if(empty($articleDetail->video_code))
				<div class="desktopDetailPhotoDiv">
					@if(!empty($articlePhotos) && (count($articlePhotos) >= 0))
					@foreach($articlePhotos as $key => $photo)
					<div class="desktopDetailPhoto">
						@if($articleDetail->categoryTitle == 'photos')
						<span class="borderC1-1 photoCounter">{{App\Http\Controllers\CommonController::GetBangla($key+1)}} / {{App\Http\Controllers\CommonController::GetBangla(count($articlePhotos))}}</span>
						@endif
						<figure>
							<img src="{!! asset('uploads/news_photos/'.date('Y/m/d/', strtotime($articleDetail->created_at)).$photo->image) !!}" class="img-responsive w100P" alt="{!! $articleDetail->headline !!}">
						</figure>
						@if(!empty($photo->image_caption))
						<figcaption>
							<p>{!! $photo->image_caption !!}</p>
						</figcaption>
						@endif
					</div>
					@endforeach
					@endif
				</div>
				@endif

				<div class="row">
					<div class="col-md-10 col-lg-10 col-md-offset-1 paddingLR50 paddingTB5">
						<!-- news body -->
						@if(!empty($articleDetails->body))
						<div class="desktopDetailBody textBodyFont{{$detailCount}}">
							<div>
								{!! $articleDetails->body !!}
							</div>
						</div>
						@endif

						<!-- news document -->
						@if(!empty($articleDetail->fileSrc) && (count($articleDetail->fileSrc)>0))
						<div class="desktopDetailDocument">
							@foreach($articleDetail->fileSrc as $key => $files)
							<p><a aria-label="{!! $files['fileCaption'] !!}" href="{{$files['fileSrc']}}" target="_blank"><i class="fa fa-file"></i> {!! $files['fileCaption'] !!}</a></p>
							@endforeach
						</div>
						@endif

						<!-- news tag -->
						@if(!empty($articleDetail->tags))
						<div class="desktopDetailTag hidden-print">
							@php $tags = explode(',', $articleDetail->tags); @endphp
							@if(!empty($tags) && (count($tags)>0))
							<p>
								@foreach($tags as $key => $tag)
								<a class="desktopTagItem" aria-label="{!! $tag !!}" href="{{url('/topic/'.implode('-', explode(' ', trim($tag))))}}">{!! $tag !!}</a>
								@endforeach
							</p>
							@endif
						</div>
						@endif

						<!-- load second detail -->
						<div class="loadAjaxDetail{{$detailCount}}"></div>


						<!-- timeline news -->
						@if(!empty($articleDetail->incident_id))
						<div class="hidden-print marginT40 timelineNewsWidgetDesktop{{$detailCount}} desktopSectionTitleSmall borderRadius5 padding10" style="display: none;border: 2px solid #017ac3;">
							<div>
								<h2 class="text-center" style="margin: 0px;margin-top: -24px;font-size: 2.4rem;"><span style="background-color: white;padding: 0px 15px;" class="color3">{!! $articleDetail->incidentInfo->title !!}</span></h2>
							</div>
							<div class="borderRadius5 customTimeline2 marginT10">
								<div id="timeline" class="ajaxTimelineNewsDivDesktop{{$detailCount}} marginL15 marginR15">
								</div>
							</div>
							<div class="borderC1T1 marginT20 text-center timelineLoadMoreDivDesktop{{$detailCount}}"><span class="paddingTB5 paddingLR15 fontNormal catReadMore loadMoreButton clickLoadMoreTimelineNewsDesktop{{$detailCount}} bgWHite border0" data-paginate="1">আরও পড়ুন <i class="fa fa-spinner loadingIcon" style="display: none;"></i></span></div>
						</div>
						@endif

						<!-- related news -->
						<div class="hidden-print relatedNewsWidgetDesktop{{$detailCount}} marginT40 desktopSectionTitleSmall" style="display: none;">
							<div class="desktopSectionTitleDiv2 marginT15">
								<h2 class="desktopSectionTitle"><a aria-label="আরও পড়ুন" href="#">আরও পড়ুন</a></h2>
							</div>
							<div class="row marginLR-10 desktopSectionListMedia desktopFlexRow ajaxRelatedNewsDivDesktop{{$detailCount}} marginT20"></div>
						</div>

						<!-- comments -->
						<div class="hidden-print marginT30 desktopSectionTitleSmall">
							<div class="desktopSectionTitleDiv2 marginT15">
								<h2 class="desktopSectionTitle"><a aria-label="মন্তব্য করুন" href="#">মন্তব্য করুন</a></h2>
							</div>
							<div class="commentsDiv{{$detailCount}} borderC1-1 borderRadius5">
								<div class="fb-comments" data-href="{!! $articleDetail->url !!}" data-numposts="2" width="100%"></div>
							</div>
						</div>

					</div>
				</div>

			</div>


			<!-- sidebar -->
			<div class="col-md-3 col-lg-3 hidden-print">
				<!-- ad -->
				<div class="row marginT0">
					<div class="col-sm-12 col-md-12 marginB20">
						<div class="adDiv w300 borderRadius5 overflowHidden">
							<a href="#" target="_blank"><img src="{!! asset('uploads/advertisements/300x250-1.jpg') !!}" align="Ad" class="img-responsive"></a>
						</div>
					</div>
				</div>
				<!-- ad -->

				<!-- latest popular news -->
				<div class="row marginT0">
					<div class="col-sm-12 col-md-12 marginB20">
						<div class="borderRadius5 borderC1-1 borderRadius5">
							<div class="tabNews bgWhiteImp height100P width100P borderRadius5" style="border: 2px solid #017ac3;">
								<ul class="nav nav-tabs borderTRadius5" role="tablist">
									<li role="presentation" class="text-center borderNone latestTab{{$detailCount}} active"><a aria-label="সর্বশেষ" class="title11" href="#latestTab" aria-controls="latestTab" role="tab" data-toggle="tab" aria-expanded="true">সর্বশেষ</a></li>
									<li role="presentation" class="text-center borderNone highestTab{{$detailCount}}"><a aria-label="পঠিত" class="title11" href="#highestTab" aria-controls="highestTab" role="tab" data-toggle="tab" aria-expanded="false">সর্বাধিক পঠিত</a></li>
								</ul>

								<div class="tab-content borderBRadius5 borderT0">
									<div role="tabpanel" class="tab-pane latestTabPan{{$detailCount}} active" id="latestTab">
										<div class="scrollbar1 latestDivHeight">
											<div class="desktopSectionListMedia listItemLastBB0 ajaxLatestNewsDivDesktop{{$detailCount}}"><div class="latestNewsLoaderDiv text-center marginT50"><i class="fa fa-spinner"></i></div></div>
										</div>
										<p class="bgBrand title11 padding10 text-center marginB0 borderBRadius3"><a class="textDecorationNone colorWhite hoverBlack" href="{!! url('latest') !!}">সব খবর</a></p>
									</div>
									<div role="tabpanel" class="tab-pane highestTabPan{{$detailCount}}" id="highestTab">
										<div class="scrollbar1 latestDivHeight">
											<div class="desktopSectionListMedia listItemLastBB0 ajaxPopularNewsDivDesktop{{$detailCount}}"><div class="popularNewsLoaderDiv text-center marginT50"><i class="fa fa-spinner"></i></div></div>
										</div>
										<p class="bgBrand title11 padding10 text-center marginB0 borderBRadius3"><a class="textDecorationNone colorWhite hoverBlack" href="{!! url('latest') !!}">সব খবর</a></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- latest popular news end -->


				<!-- category news -->
				<div class="row">
					<div class="col-md-12 col-lg-12 marginB20">
						<div class="hidden-print categoryNewsWidgetDesktop{{$detailCount}} borderC1-1 padding10 marginT5 desktopSectionTitleSmall borderRadius5" style="display: none;">
							<div class="desktopSectionTitleDiv2 marginT15">
								<h2 class="desktopSectionTitle"><a aria-label="আরও পড়ুন" href="{!! url(!empty($categoryInfo) ? $categoryInfo->title : '#') !!}">আরও পড়ুন</a></h2>
							</div>
							<div class="marginT5 desktopSectionListMedia listItemLastBB0 ajaxCategoryNewsDivDesktop{{$detailCount}}"></div>
						</div>
					</div>
				</div>


				<!-- special news -->
				@if(!empty($articleDetail->archived_topic_id))
				<div class="hidden-print specialNewsWidgetDesktop{{$detailCount}} marginT20" style="display: none;">
					<h2 class="desktopSectionTitle marginB5">{!! $articleDetail->archivedTopicInfo->topic_title !!} <span class="bottomMarked"></span></h2>
					<div class="desktopSectionListMedia ajaxSpecialNewsDivDesktop{{$detailCount}}"></div>
				</div>
				@endif

			</div>

		</div>
	</div>


	<!-- article reached -->
	<div class="articleReached{{$detailCount}}" data-url="{{$articleDetail->url}}"></div>

	@if($detailCount <= 5)
	<!-- append second detail -->
	<div class="appendAjaxDetail{{$detailCount}} hidden-print"><p class="text-center marginB0"><i class="fa fa-spinner"></i></p></div>
	@endif

</div>
<!-- desktop version end -->




<!-- mobile version start -->
<div class="visible-xs">
	<div class="hidden-print articleDividerDiv"><p><i class="fa fa-caret-down" style="margin-top: -17px;font-size: 3.5rem;color: #017ac3;"></i></p></div>

	<!-- article reached -->
	<div class="articleReached{{$detailCount}}" data-url="{{$articleDetail->url}}"></div>
	
	<div class="container">
		<div class="row">

			<!-- title section -->
			<div class="col-sm-12 col-md-12 paddingLR20">
				<div>
					<p class="desktopDetailCat marginB15"><a aria-label="{!! $articleDetail->categoryName !!}" href="{!! url($articleDetail->categoryTitle) !!}"><strong>{!! $articleDetail->categoryName !!}</strong></a></p>
					
					@if($articleDetail->shoulder)
					<p class="detailShoulder">{!! $articleDetail->shoulder !!}</p>
					@endif
					<h1 class="detailHeadline marginT0"><strong>{!! $articleDetail->headline !!}</strong></h1>
					@if($articleDetail->hanger)
					<p class="detailHanger">{!! $articleDetail->hanger !!}</p>
					@endif
					<p class="borderC1T1 marginB0"></p>

					<div class="marginT10">
						<!-- multiple author -->
						@if(!empty($articleDetail->authors) && count($articleDetail->authors)>1)
						@foreach($articleDetail->authors as $key => $authorInfo)
						<p class="detailReporter borderC1-1 borderRadius5 paddingTB3 paddingLR5 marginR5 marginB5"><a href="{!! $authorInfo->url !!}" class="textDecorationNone colorBlue hoverBlack"><img src="{!! $authorInfo->author_photo_src !!}" class="img-responsive borderRadius50P displayInlineBlock" width="25" alt="{!! $authorInfo->author_name !!}"> <span class="displayInlineBlock verticalAlignMiddle marginT3">{!! $authorInfo->author_name !!}</span></a></p>
						@endforeach
						<p class="detailPTime color1 marginT5">প্রকাশ: {!! $articleDetail->publishDateTime !!}</p>
						@if(($articleDetail->show_updatetime == 1) && !empty($articleDetail->updateDateTime))
						<p class="detailPTime color1">আপডেট: {!! $articleDetail->updateDateTime !!}</p>
						@endif
						@if(!empty($articleDetail->news_type) && ($articleDetail->news_type == 2))
						<p class="detailPTime color1">প্রিন্ট সংস্করণ</p>
						@endif

						<!-- single author -->
						@elseif(!empty($articleDetail->authors) && count($articleDetail->authors) == 1)
						@php $authorInfo = $articleDetail->authors[0]; @endphp
						<div class="detailAuthorDiv">
							<a href="{!! $authorInfo->url !!}"><img src="{!! $authorInfo->author_photo_src !!}" class="img-responsive borderRadius50P" width="40"  alt="{!! $authorInfo->author_name !!}"></a>
						</div>
						<div class="displayInlineBlock">
							<p class="detailReporter"><a href="{!! $authorInfo->url !!}" class="textDecorationNone colorBlue hoverBlack">{!! $authorInfo->author_name !!}</a></p>
							<p class="detailPTime color1">প্রকাশ: {!! $articleDetail->publishDateTime !!}</p>
							@if(($articleDetail->show_updatetime == 1) && !empty($articleDetail->updateDateTime))
							<p class="detailPTime color1">আপডেট: {!! $articleDetail->updateDateTime !!}</p>
							@endif
							@if(!empty($articleDetail->news_type) && ($articleDetail->news_type == 2))
							<p class="detailPTime color1">প্রিন্ট সংস্করণ</p>
							@endif
						</div>

						<!-- no author -->
						@else
						<div class="detailAuthorDiv">
							<img src="{!! env('UploadsLink').'uploads/settings/'.$settingsInfo->icon_2 !!}" class="img-responsive borderRadius50P" width="40" alt="Icon">
						</div>
						<div class="displayInlineBlock">
							@if(!empty($articleDetail->reporter))
							<p class="detailReporter">{!! $articleDetail->reporter !!}</p>
							@endif
							<p class="detailPTime color1">প্রকাশ: {!! $articleDetail->publishDateTime !!}</p>
							@if(($articleDetail->show_updatetime == 1) && !empty($articleDetail->updateDateTime))
							<p class="detailPTime color1">আপডেট: {!! $articleDetail->updateDateTime !!}</p>
							@endif
							@if(!empty($articleDetail->news_type) && ($articleDetail->news_type == 2))
							<p class="detailPTime color1">প্রিন্ট সংস্করণ</p>
							@endif
						</div>
						@endif
					</div>
					<!-- sharethis -->
					<div class="marginT15">
						<div class="sharethis-inline-share-buttons st-left displayInline" style="text-align: left !important;" data-url="{!! $articleDetail->url !!}"></div>
						<div class="shareCustomButton displayInline">
							<span>অ <i class="fa fa-minus clickZoomOut{{$detailCount}}" font-size="2" line-height="2.9" title="Zoom Out"></i> <i class="fa fa-plus clickZoomIn{{$detailCount}}" font-size="2" line-height="2.9" title="Zoom In"></i></span>
						</div>
					</div>
				</div>
			</div>

			<!-- video section -->
			@if(!empty($articleDetail->video_code))
			<div class="col-sm-12 col-md-12 detailVideo hidden-print">
				<div>{!! $articleDetail->video_code !!}</div>
			</div>
			@endif

			<!-- photo section -->
			@if(empty($articleDetail->video_code))
			<div class="col-sm-12 col-md-12 detailPhotoDiv">
				@if(!empty($articlePhotos) && (count($articlePhotos) >= 0))
				@foreach($articlePhotos as $key => $photo)
				<div class="detailPhoto">
					@if($articleDetail->categoryTitle == 'photos')
					<span class="borderC1-1 photoCounter">{{App\Http\Controllers\CommonController::GetBangla($key+1)}} / {{App\Http\Controllers\CommonController::GetBangla(count($articlePhotos))}}</span>
					@endif
					<figure>
						<img src="{!! asset('uploads/news_photos/'.date('Y/m/d/', strtotime($articleDetail->created_at)).$photo->image) !!}" class="img-responsive" alt="{!! $articleDetail->headline !!}">
					</figure>
					@if(!empty($photo->image_caption))
					<figcaption>
						<p>{!! $photo->image_caption !!}</p>
					</figcaption>
					@endif
				</div>
				@endforeach
				@endif
			</div>
			@endif

			<!-- body section -->
			<div class="col-sm-12 col-md-12 paddingLR20">
				<!-- news body -->
				@if(!empty($articleDetails->body))
				<div class="detailBody textBodyFont{{$detailCount}}">{!! $articleDetails->body !!}</div>
				@endif

				<!-- news document -->
				@if(!empty($articleDetail->fileSrc) && (count($articleDetail->fileSrc)>0))
				<div class="detailDocument">
					@foreach($articleDetail->fileSrc as $key => $files)
					<p><a aria-label="{!! $files['fileCaption'] !!}" href="{{$files['fileSrc']}}" target="_blank"><i class="fa fa-file"></i> {!! $files['fileCaption'] !!}</a></p>
					@endforeach
				</div>
				@endif

				<!-- news tag -->
				@if(!empty($articleDetail->tags))
				<div class="detailTag hidden-print">
					@php $tags = explode(',', $articleDetail->tags); @endphp
					@if(!empty($tags) && (count($tags)>0))
					<p>
						@foreach($tags as $key => $tag)
						<a class="tagItem" aria-label="{!! $tag !!}" href="{{url('/topic/'.implode('-', explode(' ', trim($tag))))}}">{!! $tag !!}</a>
						@endforeach
					</p>
					@endif
				</div>
				@endif
				
				<!-- load second detail -->
				<div class="loadAjaxDetail{{$detailCount}}"></div>

			</div>


			<!-- timeline news -->
			@if(!empty($articleDetail->incident_id))
			<div class="col-sm-12 col-md-12 marginT20 paddingLR20 hidden-print timelineNewsWidgetMobile{{$detailCount}}">
				<div class="borderRadius5 padding10" style="border: 2px solid #017ac3;">
					<h2 class="sectionTitle margin0 text-center paddingB10 marginB10"><span class="color3">{!! $articleDetail->incidentInfo->title !!}</span></h2>
					<div class="borderRadius5 customTimeline2">
						<div id="timeline" class="ajaxTimelineNewsDivMobile{{$detailCount}} marginL15 marginR15">
						</div>
					</div>
					<div class="borderC1T1 marginT10 text-center timelineLoadMoreDivMobile{{$detailCount}}"><span class="catReadMore paddintTB5 paddingLR15 fontNormal loadMoreButton clickLoadMoreTimelineNewsMobile{{$detailCount}} bgWHite border0 shadowUnset" data-paginate="1">আরও পড়ুন <i class="fa fa-spinner loadingIcon" style="display: none;"></i></span></div>
				</div>
			</div>
			@endif


			<!-- related news -->
			<div class="col-sm-12 col-md-12 marginT40 paddingLR20 hidden-print relatedNewsWidgetMobile{{$detailCount}}" style="display: none;">
				<div class="sectionTitleDiv3" style="margin-bottom: -25px;">
					<h2 class="sectionTitle"><a href="#">আরও পড়ুন</a></h2>
				</div>
				<div class="row desktopFlexRow paddingLR15 ajaxRelatedNewsDivMobile{{$detailCount}} sectionListMedia"></div>
			</div>


			<!-- special news -->
			@if(!empty($articleDetail->archived_topic_id))
			<div class="col-sm-12 col-md-12 marginT40 paddingLR20 hidden-print specialNewsWidgetMobile{{$detailCount}}" style="display: none;">
				<h2 class="sectionTitle marginB15">{!! $articleDetail->archivedTopicInfo->topic_title !!} <span class="bottomMarked"></span></h2>
				<div class="row desktopFlexRow paddingLR5 ajaxSpecialNewsDivMobile{{$detailCount}}"></div>
			</div>
			@endif

			<!-- category news -->
			<div class="col-sm-12 col-md-12 marginT40 paddingLR20 hidden-print categoryNewsWidgetMobile{{$detailCount}}" style="display: none;">
				<div class="sectionTitleDiv3" style="margin-bottom: -25px;">
					<h2 class="sectionTitle"><a href="#">{!! !empty($articleDetail->categoryName) ? $articleDetail->categoryName : 'আরও পড়ুন' !!} </a></h2>
				</div>
				<div class="sectionListMedia ajaxCategoryNewsDivMobile{{$detailCount}}"></div>
			</div>

		</div>
	</div>

	<!-- article reached -->
	<div class="articleReached{{$detailCount}}" data-url="{{$articleDetail->url}}"></div>

	@if($detailCount <= 5)
	<!-- append second detail -->
	<div class="appendAjaxDetail{{$detailCount}} hidden-print"><p class="text-center marginB0"><i class="fa fa-spinner"></i></p></div>
	@endif

</div>
<!-- mobile version end -->





@if($detailCount <= 5)
<!-- device wise div remove -->
<script type="text/javascript">
	var width = $(window).width();
	if(width >= 768){
		$('.visible-xs').remove();
	}
	if(width <= 767){
		$('.hidden-xs').remove();
	}
</script>

<!-- facebook comment -->
<script type="text/javascript">
	FB.XFBML.parse();
</script>


<!-- load ajax detail -->
<script type="text/javascript">
	jQuery(document).ready(function(){
		window.addEventListener('scroll', function(e){
			if(isOnScreen(jQuery('.loadAjaxDetail{{$detailCount}}'))){ 
				$('.loadAjaxDetail{{$detailCount}}').removeClass('loadAjaxDetail{{$detailCount}}');
				var url = '{{url("/")}}/ajax/load/detail/{{$mainArticleId}}/{{$categoryInfo->id}}/{{$detailCount}}';
				$.get(url, function(data){
					if(data != ''){
						$('.appendAjaxDetail{{$detailCount}}').html(data);
						if (__sharethis__ && __sharethis__.config) {
							__sharethis__.init(__sharethis__.config);
						}
					}
				});
			}	
		});
	});

	function isOnScreen(elem) {
		if(elem.length == 0){return;}
		var $window = jQuery(window)
		var viewport_top = $window.scrollTop()
		var viewport_height = $window.height()
		var viewport_bottom = viewport_top + viewport_height
		var $elem = jQuery(elem)
		var top = $elem.offset().top
		var height = $elem.height()
		var bottom = top + height
		return (top >= viewport_top && top < viewport_bottom) ||
		(bottom > viewport_top && bottom <= viewport_bottom) ||
		(height > viewport_height && top <= viewport_top && bottom >= viewport_bottom)
	}

	jQuery(document).ready(function(){
		window.addEventListener('scroll', function(e){
			if(isOnScreen(jQuery('.articleReached{{$detailCount}}'))){ 
				var currentNewsUrl = $('.articleReached{{$detailCount}}').data('url');
				var existingUrl = $(location).attr('href');
				var existingUrlEncoded = decodeURIComponent(existingUrl);
				if(existingUrlEncoded != currentNewsUrl){
					history.pushState('{{$settingsInfo->newspaper_name}}', '{{$settingsInfo->newspaper_name}}', currentNewsUrl);
					document.title = '{{$articleDetail->headline}}';
				}
			}	
		});
	});
</script>

<!-- convert english to bangla -->
<script type="text/javascript">
	function englishToBangla(val) {
		var EnlishToBanglaNumber = {'0': '০','1': '১','2': '২','3': '৩','4': '৪','5': '৫','6': '৬','7': '৭','8': '৮','9': '৯'
	};
	String.prototype.getDigitBanglaFromEnglish = function() {
		var retStr = this;
		for (var x in EnlishToBanglaNumber) {
			retStr = retStr.replace(new RegExp(x, 'g'), EnlishToBanglaNumber[x]);
		}
		return retStr;
	};
	var english_number = '' + val;
	var bangla_converted_number = english_number.getDigitBanglaFromEnglish();
	return bangla_converted_number;
}
</script>
@endif

<!-- tab script -->
<script type="text/javascript">
	$('.latestTab{{$detailCount}}').click(function(){
		$('.latestTab{{$detailCount}}').addClass('active');
		$('.highestTab{{$detailCount}}').removeClass('active');
		$('.latestTabPan{{$detailCount}}').addClass('active');
		$('.highestTabPan{{$detailCount}}').removeClass('active');
	});
	$('.highestTab{{$detailCount}}').click(function(){
		$('.highestTab{{$detailCount}}').addClass('active');
		$('.latestTab{{$detailCount}}').removeClass('active');
		$('.highestTabPan{{$detailCount}}').addClass('active');
		$('.latestTabPan{{$detailCount}}').removeClass('active');
	});
</script>

<!-- ajax news view count -->
<script type="text/javascript">
	var url = '{{url("/")}}/ajax/store/newsView/'+'{{$articleDetail->created_at}}'+'/{{$articleDetail->id}}';
	$.get(url, function(data){
		if(data != ''){
			$('.readerCount{{$detailCount}}').html(data);
		}
	})
</script>

@if(!empty($categoryInfo))
<!-- desktop ajax load category news -->
<script type="text/javascript">
	var width = $(window).width();
	if(width >= 769){
		var url = '{{url("ajax/load/categorynews/")}}/{{$categoryInfo->id}}/5/0/0';
		$.get(url, function(data){
			if(data != ''){
				$.each(data, function(key, value){
					if(value.categoryTitle == 'photos'){
						var icon = '<span class="fa fa-image ppIconSmall"></span>';
					}else if(value.video_code != null){
						var icon = '<span class="fa fa-play pvIconSmall"></span>';
					}else{
						var icon = '';
					}
					var row = $('<div class="media positionRelative marginB5"><div class="media-body"><h4 class="margin0 hoverBlue title11">'+value.fullheadline+'</h4></div><a aria-label="'+value.headline+'" href="'+value.url+'" class="linkOverlay"></a></div>');
					$('.ajaxCategoryNewsDivDesktop{{$detailCount}}').append(row);
				});			
				$('.categoryNewsWidgetDesktop{{$detailCount}}').show();
			}
		});
	}
</script>

<!-- mobile ajax load category news -->
<script type="text/javascript">
	var width = $(window).width();
	if(width <= 768){
		var url = '{{url("ajax/load/categorynews/")}}/{{$categoryInfo->id}}/4/0/0';
		$.get(url, function(data){
			if(data != ''){
				$.each(data, function(key, value){
					if(value.categoryTitle == 'photos'){
						var icon = '<span class="fa fa-image ppIconSmall"></span>';
					}else if(value.video_code != null){
						var icon = '<span class="fa fa-play pvIconSmall"></span>';
					}else{
						var icon = '';
					}
					var row = $('<div class="media positionRelative"><div class="media-left paddingL5"><div class="positionRelative"><img class="media-object borderRadius5" src="'+value.thumbSmall+'" width="140" alt="'+value.headline+'">'+icon+'</div></div><div class="media-body"><h4 class="">'+value.fullheadline+'</h4></div><a aria-label="'+value.headline+'" href="'+value.url+'" class="linkOverlay"></a></div>');
					$('.ajaxCategoryNewsDivMobile{{$detailCount}}').append(row);
				});			
				$('.categoryNewsWidgetMobile{{$detailCount}}').show();
			}
		});
	}
</script>
@endif


@if(!empty($articleDetail->archived_topic_id))
<!-- desktop ajax load special news -->
<script type="text/javascript">
	var width = $(window).width();
	if(width >= 769){
		var url = '{{url("ajax/load/specialnews/")}}/{{$articleDetail->archived_topic_id}}/4/0/0';
		$.get(url, function(data){
			if(data != ''){
				$.each(data, function(key, value){
					if(value.categoryTitle == 'photos'){
						var icon = '<span class="fa fa-image ppIconSmall"></span>';
					}else if(value.video_code != null){
						var icon = '<span class="fa fa-play pvIconSmall"></span>';
					}else{
						var icon = '';
					}
					var row = $('<div class="media positionRelative"><div class="media-body"><h4 class="title11">'+value.fullheadline+'</h4></div><div class="media-right paddingL5"><div class="positionRelative"><img class="media-object borderRadius5" src="'+value.thumbSmall+'" width="100" alt="'+value.headline+'">'+icon+'</div></div><a aria-label="'+value.headline+'" href="'+value.url+'" class="linkOverlay"></a></div>');
					$('.ajaxSpecialNewsDivDesktop{{$detailCount}}').append(row);
				});				
				$('.specialNewsWidgetDesktop{{$detailCount}}').show();
			}
		});
	}
</script>

<!-- mobile ajax load special news -->
<script type="text/javascript">
	var width = $(window).width();
	if(width <= 768){
		var url = '{{url("ajax/load/specialnews/")}}/{{$articleDetail->archived_topic_id}}/4/0/0';
		$.get(url, function(data){
			if(data != ''){
				$.each(data, function(key, value){
					if(value.categoryTitle == 'photos'){
						var icon = '<span class="fa fa-image ppIconSmall"></span>';
					}else if(value.video_code != null){
						var icon = '<span class="fa fa-play pvIconSmall"></span>';
					}else{
						var icon = '';
					}
					var row = $('<div class="col-sm-6 col-md-6 col-xs-6 paddingLR7 sectionListThumbnail"><div class="thumbnail"><div class="positionRelative"><img src="'+value.thumbMedium+'" class="img-responsive" alt="'+value.headline+'">'+icon+'</div><div class="caption"><h4>'+value.fullheadline+'</h4></div><a href="'+value.url+'" class="linkOverlay"></a></div></div>');
					$('.ajaxSpecialNewsDivMobile{{$detailCount}}').append(row);
				});				
				$('.specialNewsWidgetMobile{{$detailCount}}').show();
			}
		});
	}
</script>
@endif


@if(!empty($articleDetail->incident_id))
<!-- desktop ajax load timeline news -->
<script type="text/javascript">
	var width = $(window).width();
	if(width >= 769){
		var url = '{{url("ajax/load/timelinenews/")}}/{{$articleDetail->incident_id}}/5/0/0';
		$.get(url, function(data){
			if(data != ''){
				$.each(data, function(key, value){
					var row = $('<div class="row timeline-movement"><div class="timeline-badge"><span class="timeline-balloon-date-day"></span><span class="timeline-balloon-date-month"></span></div><div class="col-sm-3  timeline-item"><div class="row"><div class="col-sm-12"><div class="timeline-panel credits"><ul class="timeline-panel-ul"><li class="title1_7">'+value.publishTime+'</li></ul></div></div></div></div><div class="col-sm-9  timeline-item"><div class="row"><div class="col-sm-12"><div class="timeline-panel debits"><ul class="timeline-panel-ul"><li class="title11"><a class="colorBlue hoverBlack textDecorationNone" href="'+value.url+'">'+value.fullheadline+'</a></li></ul></div></div></div></div></div>');
					$('.ajaxTimelineNewsDivDesktop{{$detailCount}}').append(row);
				});				
				$('.timelineNewsWidgetDesktop{{$detailCount}}').show();
			}
		});
	}
</script>

<!-- mobile ajax load timeline news -->
<script type="text/javascript">
	var width = $(window).width();
	if(width <= 768){
		var url = '{{url("ajax/load/timelinenews/")}}/{{$articleDetail->incident_id}}/5/0/0';
		$.get(url, function(data){
			if(data != ''){
				$.each(data, function(key, value){
					var row = $('<div class="row timeline-movement"><div class="timeline-badge"><span class="timeline-balloon-date-day"></span><span class="timeline-balloon-date-month"></span></div><div class="col-sm-12  timeline-item"><div class="row"><div class="col-sm-12"><div class="timeline-panel credits"><ul class="timeline-panel-ul"><li class="title1_4">'+value.publishTime+'</li></ul></div></div></div></div><div class="col-sm-12  timeline-item"><div class="row"><div class="col-sm-12"><div class="timeline-panel debits"><ul class="timeline-panel-ul"><li class="timelineTitleM"><a class="colorBlue hoverBlack textDecorationNone" href="'+value.url+'">'+value.fullheadline+'</a></li></ul></div></div></div></div></div>');
					$('.ajaxTimelineNewsDivMobile{{$detailCount}}').append(row);
				});
				$('.timelineNewsWidgetMobile{{$detailCount}}').show();
			}
		});
	}
</script>

<!-- desktop ajax load read more timeline news -->
<script type="text/javascript">
	$('.clickLoadMoreTimelineNewsDesktop{{$detailCount}}').click(function(){
		$('.loadingIcon').show();
		var paginate = $(this).data('paginate');
		$(this).data('paginate', parseInt(paginate)+1);
		var url = '{{url("ajax/load/timelinenews/")}}/{{$articleDetail->incident_id}}/5/'+paginate+'/0';
		$.get(url, function(data){
			if(data[0] != undefined){
				$('.loadingIcon').hide();
				$.each(data, function(key, value){
					$('.loaderDiv1').hide();
					var row = $('<div class="row timeline-movement"><div class="timeline-badge"><span class="timeline-balloon-date-day"></span><span class="timeline-balloon-date-month"></span></div><div class="col-sm-3  timeline-item"><div class="row"><div class="col-sm-12"><div class="timeline-panel credits"><ul class="timeline-panel-ul"><li class="title1_7">'+value.publishTime+'</li></ul></div></div></div></div><div class="col-sm-9  timeline-item"><div class="row"><div class="col-sm-12"><div class="timeline-panel debits"><ul class="timeline-panel-ul"><li class="title11"><a class="colorBlue hoverBlack textDecorationNone" href="'+value.url+'">'+value.fullheadline+'</a></li></ul></div></div></div></div></div>');
					$('.ajaxTimelineNewsDivDesktop{{$detailCount}}').append(row);
				});	
			}else {
				$('.timelineLoadMoreDivDesktop{{$detailCount}}').hide();
			}
		});
	});
</script>

<!-- mobile ajax load read more timeline news -->
<script type="text/javascript">
	$('.clickLoadMoreTimelineNewsMobile{{$detailCount}}').click(function(){
		$('.loadingIcon').show();
		var paginate = $(this).data('paginate');
		$(this).data('paginate', parseInt(paginate)+1);
		var url = '{{url("ajax/load/timelinenews/")}}/{{$articleDetail->incident_id}}/5/'+paginate+'/0';
		$.get(url, function(data){
			if(data[0] != undefined){
				$('.loadingIcon').hide();
				$.each(data, function(key, value){
					$('.loaderDiv1').hide();
					var row = $('<div class="row timeline-movement"><div class="timeline-badge"><span class="timeline-balloon-date-day"></span><span class="timeline-balloon-date-month"></span></div><div class="col-sm-12  timeline-item"><div class="row"><div class="col-sm-12"><div class="timeline-panel credits"><ul class="timeline-panel-ul"><li class="title1_4">'+value.publishTime+'</li></ul></div></div></div></div><div class="col-sm-12  timeline-item"><div class="row"><div class="col-sm-12"><div class="timeline-panel debits"><ul class="timeline-panel-ul"><li class="timelineTitleM"><a class="colorBlue hoverBlack textDecorationNone" href="'+value.url+'">'+value.fullheadline+'</a></li></ul></div></div></div></div></div>');
					$('.ajaxTimelineNewsDivMobile{{$detailCount}}').append(row);
				});	
			}else {
				$('.timelineLoadMoreDivMobile{{$detailCount}}').hide();
			}
		});
	});
</script>
@endif


@if(!empty($articleDetail->tags))
<!-- desktop ajax load related news -->
<script type="text/javascript">
	var width = $(window).width();
	if(width >= 769){
		var url = '{{url("ajax/load/tagnews/")}}/{{$articleDetail->tags}}/{{$articleDetail->id}}/6/0/0';
		$.get(url, function(data){
			if(data != ''){
				$.each(data, function(key, value){
					if(value.categoryTitle == 'photos'){
						var icon = '<span class="fa fa-image ppIconMedium"></span>';
					}else if(value.video_code != null){
						var icon = '<span class="fa fa-play pvIconMedium"></span>';
					}else{
						var icon = '';
					}
					var row = $('<div class="col-sm-4 col-md-4 paddingLR10 desktopSectionLead marginB20"><div class="thumbnail bgUnset shadow3 borderRadius5Imp h100P"><div class="positionRelative"><img src="'+value.thumbMedium+'" class="img-responsive borderTRadius5" alt="'+value.headline+'">'+icon+'</div><div class="caption paddingTB0 paddingLR10Imp"><h3 class="title11 marginT0">'+value.fullheadline+'</h3></div><a aria-label="'+value.headline+'" href="'+value.url+'" class="linkOverlay"></a></div></div>');
					$('.ajaxRelatedNewsDivDesktop{{$detailCount}}').append(row);
				});				
				$('.relatedNewsWidgetDesktop{{$detailCount}}').show();
			}
		});
	}
</script>


<!-- mobile ajax load related news -->
<script type="text/javascript">
	var width = $(window).width();
	if(width <= 768){
		var url = '{{url("ajax/load/tagnews/")}}/{{$articleDetail->tags}}/{{$articleDetail->id}}/4/0/0';
		$.get(url, function(data){
			if(data != ''){
				$.each(data, function(key, value){
					if(value.categoryTitle == 'photos'){
						var icon = '<span class="fa fa-image ppIconSmall"></span>';
					}else if(value.video_code != null){
						var icon = '<span class="fa fa-play pvIconSmall"></span>';
					}else{
						var icon = '';
					}
					var row = $('<div class="media positionRelative"><div class="media-left paddingL5"><div class="positionRelative"><img class="media-object borderRadius5" src="'+value.thumbSmall+'" width="140" alt="'+value.headline+'">'+icon+'</div></div><div class="media-body"><h4 class="">'+value.fullheadline+'</h4></div><a aria-label="'+value.headline+'" href="'+value.url+'" class="linkOverlay"></a></div>');
					$('.ajaxRelatedNewsDivMobile{{$detailCount}}').append(row);
				});				
				$('.relatedNewsWidgetMobile{{$detailCount}}').show();
			}
		});
	}
</script>
@endif


<!-- desktop ajax load latest news -->
<script type="text/javascript">
	var width = $(window).width();
	if(width >= 769){
		$('.latestNewsLoaderDiv').show();
		var url2 = '{{url("ajax/load/latestnews/")}}/10/0/0/40';
		$.get(url2, function(data){
			if(data != ''){
				$('.latestNewsLoaderDiv').hide();
				$.each(data, function(key, value){
					if(value.categoryTitle == 'photos'){
						var icon = '<span class="fa fa-image ppIconSmall"></span>';
					}else if(value.video_code != null){
						var icon = '<span class="fa fa-play pvIconSmall"></span>';
					}else{
						var icon = '';
					}
					var row = $('<div class="media positionRelative paddingLR10"><div class="media-left paddingR5"><div class="positionRelative"><img class="media-object borderRadius5" src="'+value.thumbSmall+'" width="100" alt="'+value.headline+'">'+icon+'</div></div><div class="media-body"><h4 class="margin0 marginL5 hoverBlue title11">'+value.fullheadline+'</h4></div><a aria-label="'+value.headline+'" href="'+value.url+'" class="linkOverlay"></a></div>');
					$('.ajaxLatestNewsDivDesktop{{$detailCount}}').append(row);
				});				
				$('.latestNewsWidgetDesktop{{$detailCount}}').show();
			}
		});
	}
</script>

<!-- desktop ajax load popular news -->
<script type="text/javascript">
	var width = $(window).width();
	if(width >= 769){
		$('.popularNewsLoaderDiv').show();
		var url2 = '{{url("ajax/load/popularnews/")}}/10/0/40';
		$.get(url2, function(data){
			if(data != ''){
				$('.popularNewsLoaderDiv').hide();
				$.each(data, function(key, value){
					var number = englishToBangla(parseInt(key+1));
					var row = $('<div class="media positionRelative paddingLR10"><div class="media-left paddingR5"><div class="popularCount">'+number+'</div></div><div class="media-body"><h4 class="margin0 marginL5 hoverBlue title11">'+value.title+'</h4></div><a aria-label="'+value.title+'" href="'+value.link+'" class="linkOverlay"></a></div>');
					$('.ajaxPopularNewsDivDesktop{{$detailCount}}').append(row);
				});					
				$('.popularNewsWidgetDesktop{{$detailCount}}').show();
			}
		});
	}
</script>

<!-- font zoom in out -->
<script type="text/javascript">
	$('.shareCustomButton').on('click', '.clickZoomIn{{$detailCount}}', function(){
		var fontSize = $(this).attr('font-size');
		fontSize = (parseFloat(fontSize)+.2).toFixed(2);
		$('.clickZoomIn{{$detailCount}}').attr('font-size', fontSize);
		$('.clickZoomOut{{$detailCount}}').attr('font-size', fontSize);

		var lineHeight = $(this).attr('line-height');
		lineHeight = (parseFloat(lineHeight)+.2).toFixed(2);
		$('.clickZoomIn{{$detailCount}}').attr('line-height', lineHeight);
		$('.clickZoomOut{{$detailCount}}').attr('line-height', lineHeight);

		$('.textBodyFont{{$detailCount}} p').attr('style', 'font-size: '+fontSize+'rem !important;line-height: '+lineHeight+'rem;');
	});

	$('.shareCustomButton').on('click', '.clickZoomOut{{$detailCount}}', function(){
		var fontSize = $(this).attr('font-size');
		fontSize = (parseFloat(fontSize)-.2).toFixed(2);
		$('.clickZoomIn{{$detailCount}}').attr('font-size', fontSize);
		$('.clickZoomOut{{$detailCount}}').attr('font-size', fontSize);

		var lineHeight = $(this).attr('line-height');
		lineHeight = (parseFloat(lineHeight)-.2).toFixed(2);
		$('.clickZoomIn{{$detailCount}}').attr('line-height', lineHeight);
		$('.clickZoomOut{{$detailCount}}').attr('line-height', lineHeight);

		$('.textBodyFont{{$detailCount}} p').attr('style', 'font-size: '+fontSize+'rem !important;line-height: '+lineHeight+'rem;');
	});
</script>