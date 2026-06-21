<!DOCTYPE html>
<html lang="en" class="app">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>@yield('title') | {{$settingsInfo->newspaper_name}} Control Panel</title> 
	<link rel="icon" type="image/png" sizes="32x32" href="{{env('UploadsLink').'uploads/settings/'.$settingsInfo->icon_1}}">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="stylesheet" href="{{asset('assets/css/app.css?v=1.9')}}" type="text/css" />
  <link rel="stylesheet" href="{{asset('assets/vendors/custom/custom.css?v=1.6')}}" type="text/css" />
  <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/fontawesome/css/font-awesome.min.css')}}">

  <!-- meta -->
  <meta name="author" content="{!! $settingsInfo->newspaper_name !!}">
  <meta name="Developed By" content="{!! $settingsInfo->newspaper_name !!}" />
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

  @stack('top-scripts')

</head>

<body>

 <section class="vbox">
  <header class="bg-primary header header-md navbar navbar-fixed-top-xs box-shadow" style="background-color: #411542">
   <div class="navbar-header aside-md dk">
    <a class="btn toggleSidebar btn-link visible-xs"> <i class="fa fa-bars" style="color: black;"></i> 
    </a>
    <a href="{{url('/dashboard')}}" class="navbar-brand">
     <img src="{!! env('UploadsLink').'uploads/settings/'.$settingsInfo->logo_1 !!}" class="m-r-sm" alt="logo" style="max-height: 20px;" />
   </a>
   <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user"> <i class="i i-cog"></i> 
   </a>
 </div>

 <ul class="nav navbar-nav navbar-left m-n hidden-xs nav-user user">
  <li class="dropdown">
    <a href="#" class="dropdown-toggle text-center" data-toggle="dropdown"> <span class="thumb-sm avatar pull-left"></span><i class="fa fa-cog"></i> SETTINGS <b class="caret"></b></a>
    <ul class="dropdown-menu animated fadeInRight">
      <li style="padding: 15px;padding-bottom: 0px">
        <form method="post" action="{!! url('settings/showtopnews/update') !!}">
          @csrf
          <div class="input-group">
            <span class="input-group-addon" style="background-color: #411542;color: white;border-color: #633964;">Show Top</span>
            <input type="number" class="form-control" name="show_topnews" min="7" value="{!! !empty($settingsInfo->show_topnews) ? $settingsInfo->show_topnews : 7 !!}" placeholder="Show In Top" required="" style="min-width: 70px;border-color: #633964;background-color: #411542;color: white;">
            <span class="input-group-addon" style="border-color: #633964;background-color: #1aae88;color: white;"><button type="submit" style="background-color: #1aae88;color: white;border: none;box-shadow: unset;">Save</button></span>
          </div>
        </form>
      </li>

      <li style="padding: 15px;padding-bottom: 0px">
        <form method="post" action="{!! url('settings/showselectednews/update') !!}">
          @csrf
          <div class="input-group">
            <span class="input-group-addon" style="background-color: #411542;color: white;border-color: #633964;">Selected2</span>
            <select name="show_selected2" style="min-width: 70px;border-color: #633964;background-color: #411542;color: white;min-height: 34px;">
              <option value="">Hide</option>
              <option {!! !empty($settingsInfo->show_selected2) && $settingsInfo->show_selected2 == 1 ? 'selected' : '' !!} value="1">Show</option>
            </select>
            <span class="input-group-addon" style="border-color: #633964;background-color: #1aae88;color: white;"><button type="submit" style="background-color: #1aae88;color: white;border: none;box-shadow: unset;">Save</button></span>
          </div>
        </form>
      </li>

      <li style="padding: 15px;">
        <form method="post" action="{!! url('settings/showlive/update') !!}">
          @csrf
          <div class="input-group">
            <span class="input-group-addon" style="background-color: #411542;color: white;border-color: #633964;">Live</span>
            <select name="show_live" style="min-width: 100%;border-color: #633964;background-color: #411542;color: white;min-height: 34px;">
              <option value="">Hide</option>
              <option {!! !empty($settingsInfo->show_live) && $settingsInfo->show_live == 1 ? 'selected' : '' !!} value="1">Show</option>
            </select>
            <span class="input-group-addon" style="border-color: #633964;background-color: #1aae88;color: white;"><button type="submit" style="background-color: #1aae88;color: white;border: none;box-shadow: unset;">Save</button></span>
          </div>
        </form>
      </li>
    </ul>
  </li>

  <!-- <li>
    <form method="post" action="{!! url('settings/showtopnews/update') !!}">
      @csrf
      <div class="input-group" style="margin-top: 13px;margin-left: 15px">
        <span class="input-group-addon" style="background-color: #411542;color: white;border-color: #633964;">Show Top</span>
        <input type="number" class="form-control" name="show_topnews" min="7" value="{!! !empty($settingsInfo->show_topnews) ? $settingsInfo->show_topnews : 7 !!}" placeholder="Show In Top" required="" style="width: 70px;border-color: #633964;background-color: #411542;color: white;">
        <span class="input-group-addon" style="border-color: #633964;background-color: #411542;color: white;"><button type="submit" style="background-color: #411542;color: white;border: none;box-shadow: unset;">Save</button></span>
      </div>
    </form>
  </li> -->
</ul>

<ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user">
  <li class="dropdown">
    <a href="#" class="dropdown-toggle text-right" data-toggle="dropdown"> <span class="thumb-sm avatar pull-left"> 
    </span>LINKS <b class="caret"></b> 
  </a>
  <ul class="dropdown-menu animated fadeInRight">
    <li> <a href="{!! $settingsInfo->domain !!}" target="_blank"> {!! $settingsInfo->newspaper_name !!}</a></li>                        
    <li class="divider" style="margin: 5px 0px"></li>
    <li><a href="https://developers.facebook.com/tools/debug/" target="_blank"> Facebook Debuger</a></li>
  </ul>
</li>

<li class="dropdown">
 <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span class="thumb-sm avatar pull-left"> 
  @if(!empty($userInfoLogged->image))
  <img src="{{env('UploadsLink').'uploads/users/'.$userInfoLogged->image}}" alt="User Image" style="border-radius: 100%">
  @else
  <img src="{{env('UploadsLink').'uploads/users/default.png'}}" alt="User Image" style="border-radius: 100%">
  @endif
</span> {{ $userInfoLogged->name }}<b class="caret"></b> 
</a>
<ul class="dropdown-menu animated fadeInRight">
 <li> <a href="{{url('/users/profile')}}"> Profile</a></li>
 <li> <a href="{{route('Posts MyPost')}}"> My Post</a></li>
 <li class="divider"></li>
 <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Sign Out</a></li>
</ul>
</li>
</ul>
</header>
<section>
  <section class="hbox stretch">
   <!-- .aside -->
   <section style="width: 240px" class="toggledSidebar hidden-print">
    <aside class="page-wrapper chiller-theme toggled">
     <nav id="sidebar" class="sidebar-wrapper" style="margin-top: 60px">
      <div class="sidebar-content" style="background-color: #411542 !important">
       <div id="toggle-sidebar">
        <div></div>
        <div></div>
        <div></div>
      </div>
      <div class="sidebar-header" style="background: #411542">
        <div class="user-pic">
          @if(!empty($userInfoLogged->image))
          <img class="img-responsive img-rounded" src="{{env('UploadsLink').'uploads/users/'.$userInfoLogged->image}}" alt="User picture">
          @else
          <img class="img-responsive img-rounded" src="{{env('UploadsLink').'uploads/users/default.png'}}" alt="User picture">
          @endif
        </div>
        <div class="user-info">
         <strong>{{ $userInfoLogged->name }}</strong>
         <span class="user-role" style="color: white !important">{{$userInfoLogged->designation}}</span>
       </div>
     </div>
     <div class="sidebar-menu">
      <ul style="padding-bottom: 50px">
       <li class="header-menu" style="background-color: #281328;text-align: center;">
        <span style="font-weight: bold;color: #a1a8ac;font-size: 14px;padding: 10px 20px 5px 20px;">CONTROL PANEL</span>
      </li>

      <li class="{{ Request::is('dashboard') ? 'smenu-active' : '' }}">
        <a href="{{url('/dashboard')}}">
         <i class="fa fa-home"></i>
         <span>Dashboard</span>
       </a>
     </li>

     @if(Auth::user()->role == 'superadmin')
     @include('layouts.menus-superadmin')
     @elseif(Auth::user()->role == 'admin')
     @include('layouts.menus-admin')
     @elseif(Auth::user()->role == 'editor')
     @include('layouts.menus-editor')
     @elseif(Auth::user()->role == 'uploader')
     @include('layouts.menus-uploader')
     @endif

     <li class="sidebar-dropdown {{ Request::is('users/profile') ? 'smenu-active active' : '' }}">
      <a href="#">
       <i class="fa fa-user"></i>
       <span>My Profile</span>
     </a>
     <div class="sidebar-submenu">
       <ul>
        <li class="{{ Request::is('users/profile') ? 'smenu-active' : '' }}"><a href="{{url('/users/profile')}}"><i class="fa fa-info"></i> Profile</a></li>
        <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-lock"></i> Sign Out</a></li>
      </ul>
    </div>
  </li>
</ul>
</div>
<!-- sidebar-menu  -->
</div>
</aside>
</section>

<section id="content" style="padding-bottom: 70px">

 @yield('content')

</section>

</section>
</section>
</section>


<!-- embed modal -->
<div id="embedModal" class="modal fade" role='dialog'>
  <div class="modal-dialog">
    <div class="content">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Embed</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group">
              <div class="col-sm-12">
                <textarea class="form-control embedCodeDiv" rows="4" placeholder="Paste Embed Code.."></textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12" style="margin-top: 15px">
                <button type="submit" class="btn btn-success btn-block clickEmbedButton">Embed</button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- search modal -->
<div id="searchModal" class="modal fade" role='dialog'>
  <div class="modal-dialog">
    <div class="content">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Search Headline</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group">
              <div class="col-sm-8">
                <input type="text" class="form-control embedNewsId" placeholder="News Id" />
              </div>
              <div class="col-sm-4 paddingL0">
                <button class="btn btn-info btn-block clickEmbedNewsSearch">Search</button>
                <button class="btn btn-info btn-block clickEmbedNewsSearching" style="display: none;">Searching..</button>
              </div>
              <div class="col-sm-12" style="margin-top: 10px">
                <input class="form-control embedNews" placeholder="News" />
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12" style="margin-top: 15px">
                <button type="submit" class="btn btn-success btn-block clickAddNewsButton">Add</button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>



<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
  @csrf
</form>

<script src="{{asset('assets/js/jquery.3.3.1.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.3.3.7.js')}}"></script>
<script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('assets/js/app.plugin.js')}}"></script>

<script type="text/javascript">
  $('.clickEmbedNewsSearch').click(function(){
    $('.clickEmbedNewsSearch').hide();
    $('.clickEmbedNewsSearching').show();
    var newsID = $('#searchModal .modal-body .embedNewsId').val();
    if(newsID != ''){
      $.ajax({
        type: 'GET',
        url: '{{URL("ajax/get/newsurl")}}'+"/"+newsID,
        success: function (data) {
          $('.clickEmbedNewsSearch').show();
          $('.clickEmbedNewsSearching').hide();
          $('#searchModal .modal-body .embedNews').val(data);
        }
      });
    }
  });
</script>

<script type="text/javascript">
  jQuery(function ($) {
   $(".sidebar-dropdown > a").click(function (){
    $(".sidebar-submenu").slideUp(200);
    if($(this).parent().hasClass("active")){
     $(".sidebar-dropdown").removeClass("active");
     $(this).parent().removeClass("active");
   }else{
     $(".sidebar-dropdown").removeClass("active");
     $(this).next(".sidebar-submenu").slideDown(200);
     $(this).parent().addClass("active");
   }
 });
   $("#toggle-sidebar").click(function (){
    $(".page-wrapper").toggleClass("toggled");
  });
 });

  $(document).ready(function(){
   $(".toggleSidebar").click(function(){
    $(".toggledSidebar").toggle();
  });
 });
</script>


<script type="text/javascript">
  $('.paginationAmount').on('change',function(){
    var paginationAmount = $('.paginationAmount').val();
    var existingPaginationAmount = '{{!empty($_GET['paginationAmount']) ? $_GET['paginationAmount'] : ''}}';

    var refreshUrl = '{{Request::fullUrl()}}';
    if(existingPaginationAmount != ''){
      refreshUrl = refreshUrl.replace("paginationAmount="+existingPaginationAmount, "paginationAmount="+paginationAmount);
    }else{
      refreshUrl = '{{Request::url()}}'+'?paginationAmount='+paginationAmount;
    }
    refreshUrl = refreshUrl.replaceAll("amp;", "");
    window.location = refreshUrl;
  })
</script>

<script type="text/javascript">
  $('.replaceNow').click(function(){
    var wrongWord = $('.wrongWord').val();
    var replaceToWord = $('.replaceToWord').val();
    if(wrongWord != '' && replaceToWord != ''){
      var shoulder = $('#shoulder').val();
      if(shoulder){
        shoulder = shoulder.split(wrongWord).join(replaceToWord);
        $('#shoulder').val(shoulder);
      }

      var headline = $('#headline').val();
      if(headline){
        headline = headline.replaceAll(wrongWord, replaceToWord);
        $('#headline').val(headline);
      }

      var headline2 = $('#headline2').val();
      if(headline2){
        headline2 = headline2.split(wrongWord).join(replaceToWord);
        $('#headline2').val(headline2);
      }

      var hanger = $('#hanger').val();
      if(hanger){
        hanger = hanger.split(wrongWord).join(replaceToWord);
        $('#hanger').val(hanger);
      }

      var excerpt = $('#excerpt').val();
      if(excerpt){
        excerpt = excerpt.split(wrongWord).join(replaceToWord);
        $('#excerpt').val(excerpt);
      }

      var description = $('#description').val();
      if(description){
        description = description.split(wrongWord).join(replaceToWord);
        $('#description').val(description);
      }

      var body = $('#text-editor').summernote('code').toString();
      if(body){
        body = body.split(wrongWord).join(replaceToWord);
        $('#text-editor').summernote('code', body);
      }

      setTimeout(function() {
        alert('Success! All word replaced.');
      }, 300);
      
    }else{
      alert('Warning! Please type Wrong Word and Replaceable Word.');
    }
    
  })
</script>


@stack('bottom-scripts')

<input type="hidde" class="site_url" value="{{url('/')}}">
</body>
</html>