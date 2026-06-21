@extends('layouts.layout')
@push('meta-tag')
<title>Register - {{$settingsInfo->title}}</title>
<meta property="og:title" content="Register - {{$settingsInfo->title}}" />
<meta property="og:description" content="{{$settingsInfo->description}}" />
<meta name="description" content="{{$settingsInfo->description}}" />
<meta name="twitter:title" content="Register - {{$settingsInfo->title}}" />
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
						<div class="panel-heading text-center bgBrand colorWhite padding15 title11">Register- {!! $settingsInfo->newspaper_name !!}</div>
						<div class="panel-body">
							<form method="POST" action="{{ route('register') }}">
								@csrf

								<div class="row">
									<label for="name" class="col-md-4 text-right marginT5">{{ __('Name') }}</label>

									<div class="col-md-6">
										<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

										@error('name')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>

								<div class="row marginT10">
									<label for="email" class="col-md-4 text-right marginT5">{{ __('Email Address') }}</label>

									<div class="col-md-6">
										<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
										<input id="password" type="password" class="form-control @error('password') is-invalid @enderror passwordField" name="password" required autocomplete="new-password">
										<span class="passwordViewer" style="position: absolute;right: 0;margin-right: 25px;top: 0;margin-top: 5px;font-size: 18px;cursor: pointer;color: #bbbbbb"><i class="fa fa-eye" aria-hidden="true"></i></span>
										@error('password')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>

								<div class="row marginT10">
									<label for="password-confirm" class="col-md-4 text-right marginT5">{{ __('Confirm Password') }}</label>

									<div class="col-md-6 passwordDiv">
										<input id="password-confirm" type="password" class="form-control passwordField" name="password_confirmation" required autocomplete="new-password">
									</div>
								</div>

								<div class="row marginT10">
									<div class="col-md-3 col-md-offset-4 paddingR0 xs-paddingR15">
										<button type="submit" class="btn btn-success btn-block">{{ __('Register') }}</button>
									</div>

									<div class="col-md-3 xs-marginT10">
										<a href="{{ route('login') }}" class="btn btn-primary btn-block">{{ __('Login') }}</a>
									</div>
								</div>
							</form>
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
