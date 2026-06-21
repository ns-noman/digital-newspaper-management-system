@extends('layouts.layout')
@push('meta-tag')
<title>Verify Email - {{$settingsInfo->title}}</title>
<meta property="og:title" content="Verify Email - {{$settingsInfo->title}}" />
<meta property="og:description" content="{{$settingsInfo->description}}" />
<meta name="description" content="{{$settingsInfo->description}}" />
<meta name="twitter:title" content="Verify Email - {{$settingsInfo->title}}" />
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
						<div class="panel-heading text-center bgBrand colorWhite padding15 title11">Verify Email- {!! $settingsInfo->newspaper_name !!}</div>
						<div class="panel-body">
							@if (session('resent'))
							<div class="alert alert-success" role="alert">
								{{ __('A fresh verification link has been sent to your email address.') }}
							</div>
							@endif

							{{ __('Before proceeding, please check your email for a verification link.') }}
							{{ __('If you did not receive the email') }},
							<form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
								@csrf
								<button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
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
