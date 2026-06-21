@extends('layouts.layout')
@push('meta-tag')
<title>Reset Password - {{$settingsInfo->title}}</title>
<meta property="og:title" content="Reset Password - {{$settingsInfo->title}}" />
<meta property="og:description" content="{{$settingsInfo->description}}" />
<meta name="description" content="{{$settingsInfo->description}}" />
<meta name="twitter:title" content="Reset Password - {{$settingsInfo->title}}" />
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
						<div class="panel-heading text-center bgBrand colorWhite padding15 title11">Reset Password- {!! $settingsInfo->newspaper_name !!}</div>
						<div class="panel-body">
							@if (session('status'))
							<div class="alert alert-success" role="alert">
								{{ session('status') }}
							</div>
							@endif
							
							<form method="POST" action="{{ route('password.email') }}">
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
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-success btn-block">
											{{ __('Send Password Reset Link') }}
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
