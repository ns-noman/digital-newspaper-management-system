<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Sign In | {{$settingsInfo->newspaper_name}} Control Panel</title>
	<link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon.ico')}}" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- meta -->
	<meta name="author" content="{{$settingsInfo->newspaper_name}}">
	<meta name="Developed By" content="{{$settingsInfo->newspaper_name}}" />
	<meta name="Developer" content="{{$settingsInfo->newspaper_name}}" />
	<meta property="og:url" content="{{Request::url()}}" />
	<meta property="og:title" content="{{$settingsInfo->title}}" />
	<meta property="og:description" content="{{$settingsInfo->description}}" />
	<meta name="robots" content="noindex, nofollow" />
	<meta name="googlebot" content="noindex, nofollow" />
	<meta name="googlebot-news" content="noindex, nofollow">
	<meta name="twitter:title" content="{{$settingsInfo->title}}">
	<meta name="twitter:card" value="summary_large_image">
	<meta name="twitter:description" content="{{$settingsInfo->description}}">
	<meta name="twitter:url" content="{{Request::url()}}"/>
	<meta property="og:image" content="{!! env('UploadsLink').'uploads/settings/'.$settingsInfo->default_img_1 !!}" />
	<meta name="twitter:image" content="{!! env('UploadsLink').'uploads/settings/'.$settingsInfo->default_img_1 !!}">

	<!-- css -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
		body {
			background: linear-gradient(to right, #012633, #017AC3);
			height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
			font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
			overflow: hidden;
		}
		.login-box {
			background: #fff;
			padding: 30px;
			border-radius: 10px;
			box-shadow: 0px 4px 20px rgba(0,0,0,0.4);
			width: 350px;
		}
		.login-box h2 {
			margin-bottom: 25px;
			font-weight: bold;
			text-align: center;
			color: #017AC3;
		}
		.form-control {
			border-radius: 5px;
		}
		.input-group-addon {
			background: #017AC3;
			color: #fff;
			border: none;
			border-radius: 5px 0 0 5px;
		}
		.btn-custom {
			background: #017AC3;
			color: #fff;
			font-weight: bold;
			border-radius: 5px;
			transition: 0.3s;
		}
		.btn-custom:hover {
			background: #015f94;
		}
		.extra-links {
			margin-top: 15px;
			font-size: 13px;
		}
		.extra-links a {
			color: #017AC3;
			text-decoration: none;
		}
		.extra-links a:hover {
			text-decoration: underline;
		}
		@media screen and (max-width: 767px) {
			body {
				height: 80vh;
			}
		}
	</style>
</head>

<body>
	<div class="login-box">
		<h2><center><img src="{!! env('UploadsLink').'uploads/settings/'.$settingsInfo->logo_1 !!}" width="200px" height="60px" class="img-responsive" alt="logo" /></center></h2>

		<form method="post" action="{{ url('/login') }}" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{csrf_token()}}">

			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-user"></i></span>
					<input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" value="{!! old('email') !!}">
				</div>
				@if ($errors->has('email'))
				<span class="help-block">
					<strong>{{ $errors->first('email') }}</strong>
				</span>
				@endif
			</div>

			<div class="form-group passwordDiv">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock"></i></span>
					<input type="password" name="password" class="form-control passwordField" id="password" placeholder="Enter password">
					<span class="passwordViewer" style="position: absolute;right: 0;margin-right: 15px;top: 0;margin-top: 4px;font-size: 20px;cursor: pointer;z-index: 9;"><i class="fa fa-eye" aria-hidden="true"></i></span>
				</div>
				@if ($errors->has('password'))
				<span class="help-block">
					<strong>{{ $errors->first('password') }}</strong>
				</span>
				@endif
			</div>

			<div class="checkbox">
				<label><input type="checkbox"> Remember Me</label>
			</div>
			<button type="submit" class="btn btn-custom btn-block">Login</button>
		</form>
		<div class="extra-links text-center">
			<a href="#">Forgot Password?</a> | <a href="#">Sign Up</a>
		</div>
	</div>


	<script src="{{asset('assets/js/jquery.3.3.1.js')}}"></script>
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
</body>
</html>
