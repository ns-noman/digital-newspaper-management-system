@extends('layouts.layout')
@push('meta-tag')
<title>Login - {{$settingsInfo->title}}</title>
<meta property="og:title" content="Login - {{$settingsInfo->title}}" />
<meta property="og:description" content="{{$settingsInfo->description}}" />
<meta name="description" content="{{$settingsInfo->description}}" />
<meta name="twitter:title" content="Login - {{$settingsInfo->title}}" />
<meta name="twitter:description" content="{{$settingsInfo->description}}" />
<meta name="keywords" content="{{!empty($settingsInfo->keywords) ? $settingsInfo->keywords : ''}}" />
<meta property="og:image" content="{{asset('uploads/settings/'.$settingsInfo->default_img_1)}}" />
<meta name="twitter:image" content="{{asset('uploads/settings/'.$settingsInfo->default_img_1)}}" />
@endpush

@section('content')
<!-- desktop version and mobile start -->
<div class="bgWHite">
	<div class="container">
		<div class="row xs-marginT20">

			<div class="col-sm-6 col-md-6 col-md-offset-3">
				<div class="marginB20">
					<div class="panel panel-default padding5">
						<div class="panel-heading text-center bgBrand colorWhite padding15 title11">Login- {!! $settingsInfo->newspaper_name !!}</div>
						<div class="panel-body">
							<form method="POST" action="{{ route('login') }}">
								@csrf

								<div class="row">
									<label for="email" class="col-md-4 text-right marginT5">{{ __('Email Address') }}</label>

									<div class="col-md-6">
										<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

										@error('email')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>

								<div class="row marginT10">
									<label for="password" class="col-md-4 text-right marginT5">{{ __('Password') }}</label>

									<div class="col-md-6 passwordDiv">
										<input id="password" type="password" class="form-control @error('password') is-invalid @enderror passwordField" name="password" required autocomplete="current-password">
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
										<button type="submit" class="btn btn-success">{{ __('Login') }}</button>

										@if (Route::has('password.request'))
										<a class="btn btn-link" href="{{ route('password.request') }}">
											{{ __('Forgot Your Password?') }}
										</a>
										@endif
									</div>
								</div>
							</form>

							<div class="row marginT10">
								<hr class="marginB15">
								<div class="col-md-6 col-md-offset-4">
									<a href="{{ route('register') }}" class="btn btn-danger btn-block">{{ __('Register') }}</a>
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