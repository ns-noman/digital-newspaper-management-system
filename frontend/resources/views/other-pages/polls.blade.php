@extends('layouts.layout')
@push('meta-tag')
<title>{!! !empty($pageInfo) ? $pageInfo->meta_title : 'পাঠক জরিপ - '.$pollInfo->question !!}</title>
<meta property="og:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'পাঠক জরিপ - '.$pollInfo->question !!}" />
<meta name="twitter:title" content="{!! !empty($pageInfo) ? $pageInfo->meta_title : 'পাঠক জরিপ - '.$pollInfo->question !!}" />
<meta name="description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : $settingsInfo->description !!}" />
<meta property="og:description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : $settingsInfo->description !!}" />
<meta name="twitter:description" content="{!! !empty($pageInfo) ? $pageInfo->meta_descriptions : $settingsInfo->description !!}" />
<meta name="keywords" content="{!! !empty($pageInfo) ? $pageInfo->meta_keywords : $pollInfo->question !!}" />
<meta property="og:image" content="{!! !empty($pageInfo) && !empty($pageInfo->meta_image_src) ? $pageInfo->meta_image_src : asset('uploads/polls/'.$pollInfo->image) !!}" />
<meta name="twitter:image" content="{!! !empty($pageInfo) && !empty($pageInfo->meta_image_src) ? $pageInfo->meta_image_src : asset('uploads/polls/'.$pollInfo->image) !!}" />
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
				<h1 class="desktopCategoryTitle"><strong><span class="leftSpan"></span> পাঠক জরিপ</strong></h1>
			</div>
			<div class="col-sm-12 col-md-12 paddingLR20 marginB15 visible-xs paddingT10 marginT10">
				<h1 class="sectionTitle displayInline border0 margin0 marginB0"><strong><span class="leftSpan"></span> পাঠক জরিপ</strong></h1>
			</div>

			<div class="col-sm-9 col-md-9">
				<div class="row desktopFlexRow marginLR-10 borderLastItemNone loadMorePolls">

					<!-- poll info -->
					@if(!empty($pollInfo))
					@php $todaysQuestion = App\Models\Helper::processPoll($pollInfo); @endphp
					<div class="col-sm-12 col-md-12 paddingLR10 marginB30">
						<div class="marginCenter shadow1 borderC1-1 h100P borderRadius5" id="pollContentDiv{!! $todaysQuestion->id !!}">
							<div >
								<p class="pollTitle colorWhite">জরিপ <span class="downloadPoll" data-pollid="{!! $todaysQuestion->id !!}" data-polldate="{!! $todaysQuestion->poll_date_bangla !!}"><i class="fa fa-download"></i></span></p>
								@if(!empty($todaysQuestion->image))
								<div>
									<a class="textDecorationNone" href="{!! $todaysQuestion->url !!}">
										<img src="{!! asset('uploads/polls/'.$todaysQuestion->image) !!}" class="img-responsive" alt="{!! $todaysQuestion->question !!}">
									</a>
								</div>
								@endif
								<div class="paddingB0 pollTextDiv border0">
									<div class="thumbnail padding0 border0 marginB0">
										<div class="caption text-left paddingT0">
											<p class="desktopTime color1 marginB10"><i class="fa fa-regular fa-clock"></i> <span class="pollDate">{!! $todaysQuestion->poll_date_bangla !!}</span></p>
											<p class="title11 marginT0"><a class="textDecorationNone colorBlack" href="{!! $todaysQuestion->url !!}"><span>{!! $todaysQuestion->question !!}</span></a></p>

											<div class="marginT10">
												<p class="pollOption"><label class="clickVote" data-pollid="{!! $todaysQuestion->id !!}" data-votetype="yes"><input class="clickVoteInput{!! $todaysQuestion->id !!}" type="radio" name="poll_vote" value="yes"> হ্যাঁ ভোট <span class="pull-right totalyesVote{!! $todaysQuestion->id !!}">{!! $todaysQuestion->yes_vote_percent_bangla !!} %</span></label></p>

												<p class="pollOption"><label class="clickVote" data-pollid="{!! $todaysQuestion->id !!}" data-votetype="no"><input class="clickVoteInput{!! $todaysQuestion->id !!}" type="radio" name="poll_vote" value="no"> না ভোট <span class="pull-right totalNoVote{!! $todaysQuestion->id !!}">{!! $todaysQuestion->no_vote_percent_bangla !!} %</span></label></p>

												<p class="pollOption"><label class="clickVote" data-pollid="{!! $todaysQuestion->id !!}" data-votetype="no_comment"><input class="clickVoteInput{!! $todaysQuestion->id !!}" type="radio" name="poll_vote" value="no_comment"> মন্তব্য নেই <span class="pull-right totalNoCommentVote{!! $todaysQuestion->id !!}">{!! $todaysQuestion->no_opinion_vote_percent_bangla !!} %</span></label></p>
											</div>

											<div class="text-center marginT20 marginB20">
												<p class="title11 color1">মোট ভোটদাতাঃ <span class="totalVoter{!! $todaysQuestion->id !!}">{!! App\Models\Helper::GetBangla($todaysQuestion->total_vote_bangla) !!}</span> জন</p>
											</div>

											<div class="text-center marginT10 pollDownloadTime" style="display: none;">
												<p class="marginT30 marginB0"><img src="{!! asset('uploads/settings/'.$settingsInfo->logo_1) !!}" class="img-responsive marginCenter h50" alt="Logo"></p>
												<p class="title1_6 colorBlack">ডাউনলোডঃ {!! App\Models\Helper::GetBangla(date('d M Y, H:i A')) !!}</p>
											</div>

											<div class="row downloadPollShareIcon">
												<div class="col-xs-12 text-center marginB10">
													<!-- sharethis -->
													<div class="sharethis-inline-share-buttons" style="text-align: center;" data-url="{!! $todaysQuestion->url !!}" data-title="{!! $todaysQuestion->question !!}"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endif

					<!-- polls -->
					@if(!empty($polls) && (count($polls)>0))
					@foreach($polls as $key => $poll)
					@php $todaysQuestion = App\Models\Helper::processPoll($poll); @endphp
					<div class="col-sm-4 col-md-4 paddingLR10 marginB20">
						<div class="marginCenter borderC1-1 h100P borderRadius5" id="pollContentDiv{!! $todaysQuestion->id !!}">
							<div >
								<p class="pollTitle colorWhite">জরিপ <span class="downloadPoll" data-pollid="{!! $todaysQuestion->id !!}" data-polldate="{!! $todaysQuestion->poll_date_bangla !!}"><i class="fa fa-download"></i></span></p>
								@if(!empty($todaysQuestion->image))
								<div>
									<a class="textDecorationNone" href="{!! $todaysQuestion->url !!}">
										<img src="{!! asset('uploads/polls/'.$todaysQuestion->image) !!}" class="img-responsive" alt="{!! $todaysQuestion->question !!}">
									</a>
								</div>
								@endif
								<div class="paddingB0 pollTextDiv border0">
									<div class="thumbnail padding0 border0 marginB0">
										<div class="caption text-left paddingT0">
											<p class="desktopTime color1 marginB10"><i class="fa fa-regular fa-clock"></i> <span class="pollDate">{!! $todaysQuestion->poll_date_bangla !!}</span></p>
											<p class="title11 marginT0"><a class="textDecorationNone colorBlack" href="{!! $todaysQuestion->url !!}"><span>{!! $todaysQuestion->question !!}</span></a></p>

											<div class="marginT10">
												<p class="pollOption"><label class="clickVote" data-pollid="{!! $todaysQuestion->id !!}" data-votetype="yes"><input class="clickVoteInput{!! $todaysQuestion->id !!}" type="radio" name="poll_vote" value="yes"> হ্যাঁ ভোট <span class="pull-right totalyesVote{!! $todaysQuestion->id !!}">{!! $todaysQuestion->yes_vote_percent_bangla !!} %</span></label></p>

												<p class="pollOption"><label class="clickVote" data-pollid="{!! $todaysQuestion->id !!}" data-votetype="no"><input class="clickVoteInput{!! $todaysQuestion->id !!}" type="radio" name="poll_vote" value="no"> না ভোট <span class="pull-right totalNoVote{!! $todaysQuestion->id !!}">{!! $todaysQuestion->no_vote_percent_bangla !!} %</span></label></p>

												<p class="pollOption"><label class="clickVote" data-pollid="{!! $todaysQuestion->id !!}" data-votetype="no_comment"><input class="clickVoteInput{!! $todaysQuestion->id !!}" type="radio" name="poll_vote" value="no_comment"> মন্তব্য নেই <span class="pull-right totalNoCommentVote{!! $todaysQuestion->id !!}">{!! $todaysQuestion->no_opinion_vote_percent_bangla !!} %</span></label></p>
											</div>

											<div class="text-center marginT20 marginB20">
												<p class="title11 color1">মোট ভোটদাতাঃ <span class="totalVoter{!! $todaysQuestion->id !!}">{!! App\Models\Helper::GetBangla($todaysQuestion->total_vote_bangla) !!}</span> জন</p>
											</div>

											<div class="text-center marginT10 pollDownloadTime" style="display: none;">
												<p class="marginT30 marginB0"><img src="{!! asset('uploads/settings/'.$settingsInfo->logo_1) !!}" class="img-responsive marginCenter h50" alt="Logo"></p>
												<p class="title1_6 colorBlack">ডাউনলোডঃ {!! App\Models\Helper::GetBangla(date('d M Y, H:i A')) !!}</p>
											</div>

											<div class="row downloadPollShareIcon">
												<div class="col-xs-12 text-center marginB10">
													<!-- sharethis -->
													<div class="sharethis-inline-share-buttons" data-url="{!! $todaysQuestion->url !!}" data-title="{!! $todaysQuestion->question !!}"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endforeach
					@endif
				</div>


				<!-- load more button -->
				<div class="text-center marginT15 xs-marginB30">
					<span data-paginate="1" class="loadMoreButton clickLoadMoreDesktop">আরও <i class="fa fa-spinner loadingIcon" style="display: none;"></i></span>
				</div>
				<!-- load more button -->

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
<!-- ajax load more polls -->
<script type="text/javascript">
	$('.clickLoadMoreDesktop').click(function(){
		$('.loadingIcon').show();
		var paginate = $(this).data('paginate');
		$(this).data('paginate', parseInt(paginate)+1);
		var url = '{{url("ajax/load/polls/")}}/10/'+paginate;
		$.get(url, function(data){
			if(data != ''){
				$('.loadingIcon').hide();
				$.each(data, function(key, value){

					var poll_image = '';
					if(value.image != ''){
						var poll_image = '<div><a class="textDecorationNone" href="'+value.url+'"><img src="{!! asset('uploads/polls/') !!}/'+value.image+'" class="img-responsive" alt="'+value.question+'"></a></div>';
					}
					
					var row = $('<div class="col-sm-4 col-md-4 paddingLR10 marginB20"><div class="marginCenter borderC1-1 h100P borderRadius5" id="pollContentDiv'+value.id+'"><div ><p class="pollTitle colorWhite">জরিপ <span class="downloadPoll" data-pollid="'+value.id+'" data-polldate="'+value.poll_date_bangla+'"><i class="fa fa-download"></i></span></p>'+poll_image+'<div class="paddingB0 pollTextDiv border0"><div class="thumbnail padding0 border0 marginB0"><div class="caption text-left paddingT0"><p class="desktopTime color1 marginB10"><i class="fa fa-regular fa-clock"></i> <span class="pollDate">'+value.poll_date_bangla+'</span></p><p class="title4 marginT0"><a class="textDecorationNone colorBlack" href="'+value.url+'"><span>'+value.question+'</span></a></p><div class="marginT10"><p class="pollOption"><label class="clickVote" data-pollid="'+value.id+'" data-votetype="yes"><input class="clickVoteInput'+value.id+'" type="radio" name="poll_vote" value="yes"> হ্যাঁ ভোট <span class="pull-right totalyesVote'+value.id+'">'+value.yes_vote_percent_bangla+' %</span></label></p><p class="pollOption"><label class="clickVote" data-pollid="'+value.id+'" data-votetype="no"><input class="clickVoteInput'+value.id+'" type="radio" name="poll_vote" value="no"> না ভোট <span class="pull-right totalNoVote'+value.id+'">'+value.no_vote_percent_bangla+' %</span></label></p><p class="pollOption"><label class="clickVote" data-pollid="'+value.id+'" data-votetype="no_comment"><input class="clickVoteInput'+value.id+'" type="radio" name="poll_vote" value="no_comment"> মন্তব্য নেই <span class="pull-right totalNoCommentVote'+value.id+'">'+value.no_opinion_vote_percent_bangla+' %</span></label></p></div><div class="text-center marginT20 marginB20"><p class="title12 color1">মোট ভোটদাতাঃ <span class="totalVoter'+value.id+'">'+value.total_vote_bangla+'</span> জন</p></div><div class="text-center marginT10 pollDownloadTime" style="display: none;"><p class="marginT30 marginB0"><img src="{!! asset('uploads/settings/'.$settingsInfo->logo_1) !!}" style="height: 50px;" class="img-responsive marginCenter" alt="Logo"></p><p class="title1_6 colorBlack">ডাউনলোডঃ '+englishToBangla('{{date('d M Y, H:i A')}}')+'</p></div><div class="row downloadPollShareIcon"><div class="col-xs-12 text-center marginB10"><div class="sharethis-inline-share-buttons" data-url="'+value.url+'"></div></div></div></div></div></div></div></div></div>');

					$('.loadMorePolls').append(row);
				});
			}
		});
	});
</script>
@endpush