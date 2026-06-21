@extends('layouts.layout')
@push('meta-tag')
<title>Profile- {!! $profileInfo->name !!} - {{$settingsInfo->title}}</title>
<meta property="og:title" content="Profile- {!! $profileInfo->name !!} - {{$settingsInfo->title}}" />
<meta property="og:description" content="{{$settingsInfo->description}}" />
<meta name="description" content="{{$settingsInfo->description}}" />
<meta name="twitter:title" content="Profile- {!! $profileInfo->name !!} - {{$settingsInfo->title}}" />
<meta name="twitter:description" content="{{$settingsInfo->description}}" />
<meta name="keywords" content="{{!empty($settingsInfo->keywords) ? $settingsInfo->keywords : ''}}" />
<meta property="og:image" content="{{asset('uploads/settings/'.$settingsInfo->default_img_1)}}" />
<meta name="twitter:image" content="{{asset('uploads/settings/'.$settingsInfo->default_img_1)}}" />
<meta name="robots" content="index, follow" />

<style type="text/css">
	.textBody p{
		text-align: left !important;
		margin-bottom: 5px !important;
	}
	.textBody span{
		text-align: left !important;
		margin-bottom: 5px !important;
	}
</style>
@endpush

@section('content')
<!-- desktop version and mobile start -->
<div class="bgWHite">
	<div class="container">
		<div class="row xs-marginT20">
			<div class="col-sm-4 col-md-4">
				<div class="xs-marginT0 marginB20 hoverBlue">
					<div class="card bg2 hovercard marginT0 paddingT20 paddingB0 text-center borderRadius5 borderD2C1 positionRelative">
						<div class="avatar">
							<img width="150" src="{{asset('uploads/authors/default.png')}}" alt="{{$profileInfo->name}}" title="{{$profileInfo->name}}" class="borderRadius50P" style="border: 5px solid white">
						</div>
						<div class="info marginT15 padding10 bgWHite borderBRadius5">
							<div class="row paddingLR10">
								<div class="col-md-6 col-xs-6">
									<div class="title">
										<p class="title11 textDecorationNone marginT5 colorBlack text-left"><strong>{{$profileInfo->name}}</strong></p>
									</div>
								</div>

								<div class="col-md-6 col-xs-6">
									<div class="text-right">
										<button type="button" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</button>
										<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
											@csrf
										</form>
									</div>
								</div>
							</div>
							
							<div class="marginT0 text-left paddingLR10 borderC1T1 paddingT10">
								@if(!empty($profileInfo->email))
								<p class="title12 xs-title1_4 colorBlack">Email: {{$profileInfo->email}}</p>
								@endif
								@if(!empty($profileInfo->phone))
								<p class="title12 xs-title1_4 colorBlack">Phone: {{$profileInfo->phone}}</p>
								@endif
								@if(!empty($profileInfo->address))
								<p class="title12 xs-title1_4 colorBlack">Address: {{$profileInfo->address}}</p>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- first sidebar -->
			<div class="col-sm-8 col-md-8">
				<div>

					@if(session('success_message'))
					<div class="alert alert-success text-center alert-dismissable fade in">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>{{session('success_message')}} </strong>
					</div>
					@endif

					@if(session('error_message'))
					<div class="alert alert-danger text-center alert-dismissable fade in">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>{{session('error_message')}} </strong>
					</div>
					@endif

					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#newsList" aria-controls="newsList" role="tab" data-toggle="tab" class="title1_8 xs-title1_4">Subscribed News</a></li>
						<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab" class="title1_8 xs-title1_4">Profile & Password</a></li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content borderC3-2 padding20" style="margin-top: -2px">
						<div role="tabpanel" class="tab-pane active" id="newsList">
							<div class="row">
								@if(!empty($subscribedNewsList) && (count($subscribedNewsList)>0))
								<div class="col-sm-12 col-md-12">
									<div class="desktopSectionListMedia loadMoreCategoryNews">
										@for($i=0; $i<=9; $i++)
										@if(!empty($subscribedNewsList[$i]))
										@php $article = \App\Models\Helper::processArticleShortly($subscribedNewsList[$i], 15); @endphp
										<div class="media positionRelative">
											<div class="media-left">
												<div class="positionRelative">
													<img class="media-object borderRadius5 xs-width120" src="{!! $article->thumbMedium !!}" width="270" alt="{!! $article->headline !!}">
													@if($article->categoryTitle == 'photos')
													<span class="fa fa-image ppIconSmall"></span>
													@elseif(!empty($article->video_code))
													<span class="fa fa-play pvIconSmall"></span>
													@endif
												</div>
											</div>
											<div class="media-body marginL5">
												<p class="title11 xs-title1_6 marginT2">{!! $article->fullheadline !!}</p>
												@if(!empty($article->summary))
												<p class="desktopSummary marginT10 hidden-xs">{!! $article->summary !!}</p>
												@endif
												<p class="desktopTime marginT10 hidden-xs"><span class="colorBlue"><i class="fa fa-regular fa-tag colorBlue"></i> {!! $article->categoryName !!}</span> <i class="fa fa-grip-lines-vertical marginL5 marginR5"></i> <i class="fa fa-regular fa-clock"></i> {!! $article->publishTime !!}</p>
											</div>
											<a href="{!! $article->url !!}" class="linkOverlay"></a>
										</div>
										@endif
										@endfor
									</div>

									<div class="text-center marginT20">{{$subscribedNewsList->appends(request()->query())->links()}}</div>
								</div>
								@else
								<div class="col-sm-12 col-md-12">
									<div class="text-center">No Data Found</div>
								</div>
								@endif
							</div>
						</div>

						<div role="tabpanel" class="tab-pane" id="profile">
							<div>
								<form method="post" action="{!! url('profile/update') !!}">
									@csrf
									<div class="row">
										<label class="col-md-4 text-right marginT15">Name</label>
										<div class="col-md-6">
											<input type="text" class="form-control" name="name" value="{!! $profileInfo->name !!}" required autocomplete="name" autofocus>
											@error('name')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
									</div>

									<div class="row marginT10">
										<label class="col-md-4 text-right marginT15">Email</label>
										<div class="col-md-6">
											<input type="email" class="form-control" name="email" value="{!! $profileInfo->email !!}" required autocomplete="email">
											@error('email')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
									</div>

									<div class="row marginT10">
										<label class="col-md-4 text-right marginT15">Phone</label>
										<div class="col-md-6">
											<input type="text" class="form-control" name="phone" value="{!! $profileInfo->phone !!}" required autocomplete="phone">
											@error('phone')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
									</div>

									<div class="row marginT10">
										<label class="col-md-4 text-right marginT15">Address</label>
										<div class="col-md-6">
											<textarea type="text" class="form-control" name="address" rows="3">{!! $profileInfo->address !!}</textarea>
											@error('address')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
									</div>

									<div class="row marginT10">
										<label class="col-md-4 text-right marginT15">Password</label>
										<div class="col-md-6 passwordDiv">
											<input type="password" class="form-control passwordField" name="password">
											<span class="passwordViewer" style="position: absolute;right: 0;margin-right: 25px;top: 0;margin-top: 5px;font-size: 18px;cursor: pointer;color: #bbbbbb"><i class="fa fa-eye" aria-hidden="true"></i></span>
											@error('password')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
									</div>

									<div class="row marginT10">
										<div class="col-md-6 col-md-offset-4">
											<button type="submit" class="btn btn-success btn-block">Update</button>
										</div>
									</div>

								</div>
							</div>
						</div>

					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- desktop and mobile version end -->
	@endsection

	@push('js')
	<script type="text/javascript">
		$('.passwordDiv').on('click', '.passwordViewer', function(){
			$('.passwordField').attr('type', 'text');
			$('.passwordViewer').addClass('passwordHider');
			$('.passwordViewer').removeClass('passwordViewer');
		});
		$('.passwordDiv').on('click', '.passwordHider', function(){
			$('.passwordField').attr('type', 'password');
			$('.passwordHider').addClass('passwordViewer');
			$('.passwordHider').removeClass('passwordHider');
		});
	</script>
	@endpush