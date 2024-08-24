@php
    $basicInfo = App\Models\BasicInfo::first();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Login Page | {{ $basicInfo->title }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backend-assets') }}/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backend-assets') }}/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backend-assets') }}/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backend-assets') }}/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backend-assets') }}/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backend-assets') }}/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backend-assets') }}/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backend-assets') }}/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ asset('public/backend-assets') }}/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backend-assets') }}/pages/css/login.min.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/uploads/basic-info/'. $basicInfo->favIcon) }}">
</head>
<body class="login">
    <div class="menu-toggler sidebar-toggler"></div>
    <div class="logo">
        <a href="#">
            <img src="{{ asset('public/uploads/basic-info/'. $basicInfo->logo) }}" alt="" />
        </a>
    </div>
    <div class="content">
        <form method="POST" action="{{ url('admin/login') }}">
        <h3 class="form-title font-green">Sign In</h3>
        @csrf
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Username/Email</label>
                <input name="email" class="form-control form-control-solid placeholder-no-fix" autocomplete="off" placeholder="Username/Email" :value="old('email')" required autofocus/>
                <span style="color: red;"></span>
            </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Password</label>
                <input type="password" name="password" class="form-control form-control-solid placeholder-no-fix" required autocomplete="current-password" placeholder="Password" :value="old('email')" required autofocus/>
                <span style="color: red;"></span>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn green uppercase">Login</button>
                <label class="rememberme check">
                    <input type="checkbox" name="remember_me" id="">
                    Remember</label>
                <a class="forget-password" href="{{ '#' }}">Forgot Password?</a>
            </div>
            <div class="create-account">
                <p></p>
            </div>
        </form>
    </div>
    <div class="copyright">{{ date("Y") }} © <a href="http://www.facebd.net" target="_blank">{{ $basicInfo->title }}</a></div>
    <script src="{{ asset('public/backend-assets') }}/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="{{ asset('public/backend-assets') }}/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="{{ asset('public/backend-assets') }}/global/plugins/js.cookie.min.js" type="text/javascript"></script>
    <script src="{{ asset('public/backend-assets') }}/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
    <script src="{{ asset('public/backend-assets') }}/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="{{ asset('public/backend-assets') }}/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="{{ asset('public/backend-assets') }}/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <script src="{{ asset('public/backend-assets') }}/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <script src="{{ asset('public/backend-assets') }}/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="{{ asset('public/backend-assets') }}/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
    <script src="{{ asset('public/backend-assets') }}/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="{{ asset('public/backend-assets') }}/global/scripts/app.min.js" type="text/javascript"></script>
    <script src="{{ asset('public/backend-assets') }}/pages/scripts/login.min.js" type="text/javascript"></script>
    <span class="siteinfo" data-baseurl="{{ asset('public/backend-assets') }}"></span>
</body>
</html>
