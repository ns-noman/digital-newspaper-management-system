@extends('layouts.layout')
@push('meta-tag')
<title>Change Password - {{$settingsInfo->title}}</title>
<meta property="og:title" content="Change Password - {{$settingsInfo->title}}" />
<meta property="og:description" content="{{$settingsInfo->description}}" />
<meta name="description" content="{{$settingsInfo->description}}" />
<meta name="twitter:title" content="Change Password - {{$settingsInfo->title}}" />
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
						<div class="panel-heading text-center bgBrand colorWhite padding15 title11">Change Password- {!! $settingsInfo->newspaper_name !!}</div>

						<div class="panel-body">
							<form method="POST" action="{{ route('password.update') }}">
								@csrf

								<input type="hidden" name="token" value="{{ $token }}">

								<div class="row">
									<label for="email" class="col-md-4 text-right marginT5">{{ __('Email Address') }}</label>

									<div class="col-md-6">
										<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

										@error('email')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>

								<div class="row marginT10">
									<label for="password" class="col-md-4 text-right marginT5">{{ __('Password') }}</label>

									<div class="col-md-6">
										<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

										@error('password')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>

								<div class="row marginT10">
									<label for="password-confirm" class="col-md-4 text-right marginT5">{{ __('Confirm Password') }}</label>

									<div class="col-md-6">
										<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
									</div>
								</div>

								<div class="row marginT10">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-success btn-block">
											{{ __('Reset Password') }}
										</button>
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

@endpush

