<!doctype html>
<html lang="bn">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" sizes="32x32" href="{{asset('uploads/settings/'.$settingsInfo->icon_1)}}">
	<link rel="manifest" href="/manifest.json" />
	<script src="/app.js"></script>
	<meta name="theme-color" content="{!! $settingsInfo->brand_color !!}">
	<meta name="msapplication-TileColor" content="{!! $settingsInfo->brand_color !!}">
	<meta name="msapplication-navbutton-color" content="{!! $settingsInfo->brand_color !!}">
	<meta name="mobile-web-app-capable" content = "yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="{!! $settingsInfo->brand_color !!}">
	<meta name="apple-mobile-web-app-title" content="bKhabor" />

	@stack('meta-tag')
	<meta name="distribution" content="Global">
	<meta http-equiv="Content-Language" content="bn"/>
	<meta name="robots" content="ALL" />
	<meta name="Developed By" content="{!! $settingsInfo->newspaper_name !!}" />
	<meta name="Developer" content="{!! $settingsInfo->newspaper_name !!}" />
	<meta property="fb:pages" content="{!! $settingsInfo->fb_pages !!}" />
	<meta property="fb:app_id" content="{!! $settingsInfo->fb_app_id !!}" />
	<meta property="og:site_name" content="{!! $settingsInfo->newspaper_name !!}" />
	<meta property="og:url" content="{{str_replace('/index.php', '', Request::url())}}" />
	<meta name="twitter:card" value="summary_large_image" />
	<meta name="twitter:site" content="" />
	<meta name="twitter:creator" content="" />
	<link rel="canonical" href="{{str_replace('/index.php', '', Request::url())}}" />
	
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Bengali:wght@100..900&display=swap" rel="stylesheet">
	<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Calibri"> -->
	<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/bootstrap3.7/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/datepicker/bootstrap-datepicker.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/fontawesome6/css/fontawesome.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/fontawesome6/css/brands.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/fontawesome6/css/solid.css')}}">
	<link rel="stylesheet" href="{{asset('assets/vendors/flex-gallery/flexslider.css')}}" type="text/css" media="screen" />
	<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/custom/custom.css?v=1.148')}}">

	@stack('css')

	<!-- header code -->
	@php echo $settingsInfo->header_code; @endphp

	<!-- ad tags -->
	@stack('adTags')

	<style type="text/css">
		.st-hidden {
			opacity: 1 !important;
		}
		#st-1 .st-total .st-hidden {
			display: inline-block !important;
		}
		.sharethis-inline-share-buttons .st-last{
			display: inline-block !important;
		}
	</style>

</head>

<body>
	<!-- body code -->
	@php echo $settingsInfo->body_code; @endphp

	<!-- desktop header -->
	<div class="hidden-xs hidden-print desktopHeaderDiv">
		<div class="container bgWhite">
			<div class="row">
				<div class="col-md-4">
					<div class="desktopHeaderLogoLeftDiv">
						<span style="line-height: 2.2rem; font-size: 2.2rem" class="desktopSearchIcon cursorPointer allMenu desktopClickLoadMenubarCategories marginT0"><i class="fa fa-bars w20"></i></span>
						<span class="desktopSearchIcon cursorPointer allMenu marginT0" style="display: none;line-height: 2.2rem; font-size: 2.2rem"><i class="fa fa-times w20"></i></span>
						<a aria-label="Search" title="Search" href="{!! url('search') !!}" class="desktopSearchIcon colorBlack marginL5" style="border: 1px solid #212121;border-radius: 50%;height: 23px;width: 23px;vertical-align: middle;text-align: center;margin-top: -1px;"><i class="fa fa-search" style="font-size: 1.4rem;vertical-align: middle;margin-top: -4px;"></i></a>
						<span aria-label="Theme Color" title="Theme Color" class="desktopSearchIcon colorBlack marginL5 shadow1 clickToThemeMode" style="border-radius: 50%;height: 23px;width: 23px;vertical-align: middle;text-align: center;margin-top: -1px;"><i class="fa fa-moon" style="font-size: 1.4rem;vertical-align: middle;margin-top: -4px;"></i></span>
						@if(Auth::check())
						<a aria-label="Login" title="Login" href="{!! url('profile') !!}" class="desktopSearchIcon colorBlack marginL5 shadow1 borderC1-1 textDecorationNone" style="vertical-align: middle;text-align: center;margin-top: -1px;font-size: 1.6rem;padding: 1px 10px;border-radius: 5px;font-weight: normal;"><i class="fa fa-user" style="font-size: 1.2rem;vertical-align: middle;margin-top: -4px;"></i> Profile</a>
						@else
						<a aria-label="Login" title="Login" href="{!! url('login') !!}" class="desktopSearchIcon colorBlack marginL5 shadow1 borderC1-1 textDecorationNone" style="vertical-align: middle;text-align: center;margin-top: -1px;font-size: 1.6rem;padding: 1px 10px;border-radius: 5px;font-weight: normal;">Login</a>
						@endif

						<span id="selectHeaderDate" class="desktopTodayDate todaysDate displayBlock marginT7"></span>
					</div>
				</div>
				<div class="col-md-4">
					<div class="text-center padding15 marginT8">
						<a class="logoLight" aria-label="Logo" href="{!! url('/') !!}"><img src="{!! asset('uploads/settings/'.$settingsInfo->logo_1) !!}" alt="Logo" height="35"></a>
						<a class="logoDark" style="display: none;" aria-label="Logo" href="{!! url('/') !!}"><img src="{!! asset('uploads/settings/'.$settingsInfo->logo_2) !!}" alt="Logo" height="35"></a>
					</div>
				</div>
				<div class="col-md-4">
					<div class="topSocialIcon text-right marginT5">
						<a aria-label="Facebook" href="{!! $settingsInfo->facebook ? $settingsInfo->facebook : '#' !!}" target="_blank" class="fa fa-brands fa-facebook"></a>
						<a aria-label="Twitter" href="{!! $settingsInfo->twitter ? $settingsInfo->twitter : '#' !!}" target="_blank" class="fa fa-brands fa-x-twitter"></a>
						<a aria-label="Linkedin" href="{!! $settingsInfo->linkedin ? $settingsInfo->linkedin : '#' !!}" target="_blank" class="fa fa-brands fa-linkedin"></a>
						<a aria-label="Instagram" href="{!! $settingsInfo->instagram ? $settingsInfo->instagram : '#' !!}" target="_blank" class="fa fa-brands fa-instagram"></a>
						<a aria-label="Youtube" href="{!! $settingsInfo->youtube ? $settingsInfo->youtube : '#' !!}" target="_blank" class="fa fa-brands fa-youtube"></a>
					</div>
					<div class="desktopHeaderLogoRightDiv">
						<a aria-label="লাইভ" href="{{url('live')}}">লাইভ</a>
						<span><i class="fa fa-grip-lines-vertical"></i></span>
						<a aria-label="ই-পেপার" href="{{$settingsInfo->another_site}}" target="_blank">ই-পেপার</a>
						<span><i class="fa fa-grip-lines-vertical"></i></span>
						<a aria-label="আর্কাইভ" href="{{url('archive')}}">আর্কাইভ</a>
						<span><i class="fa fa-grip-lines-vertical"></i></span>
						<a aria-label="বাংলা কনভার্টার" href="{{url('bn-converter')}}" target="_blank">কনভার্টার</a>
					</div>
				</div>
			</div>
		</div>

		<nav id="navbar_top" class="navbar navbar-expand-lg bgRed">
			<div class="container">
				<div class="row">
					<div class="stickyNavLeftDiv" style="display: none;">
						<div class="text-left stickyLogo marginT5">
							<a aria-label="Logo" href="{!! url('/') !!}"><img src="{!! asset('uploads/settings/'.$settingsInfo->logo_2) !!}" alt="Logo"  style="height: 25px" class=""></a>
						</div>
					</div>
					<div class="col-md-12 stickyNavMiddleDiv">
						<div class="headerMenu marginT2">
							<ul>
								<li><a aria-label="সর্বশেষ" href="{!! url('todays-news') !!}">সর্বশেষ</a></li>
								@if(!empty($headerCategories) && (count($headerCategories)>0))
								@foreach($headerCategories as $headerCategory)
								<li><a aria-label="{!! $headerCategory->display_name !!}" href="{!! url($headerCategory->title) !!}">{!! $headerCategory->display_name !!}</a></li>
								@endforeach
								@endif
							</ul>
						</div>
					</div>
					<div class="stickyNavRightDiv" style="display: none;">
						<div class="text-right stickyLogo">
							<a aria-label="Search" href="{!! url('search') !!}" class="desktopSearchIcon"><i class="fa fa-search title1_7"></i></a>
							<span class="desktopSearchIcon marginL10 cursorPointer allMenu desktopClickLoadMenubarCategories"><i class="fa fa-bars w17"></i></span>
							<span class="desktopSearchIcon marginL10 cursorPointer allMenu" style="display: none;"><i class="fa fa-times w17 title2_0"></i></span>
						</div>
					</div>
				</div>
			</div>

			<div class="megaMenu megaMenuDiv">
				<div class="bgWhiteImp">
					<div class="container paddingT30 paddingB30">
						<div class="col-md-10 borderC1R1"><div class="desktopLoadMenubarCategories row"><div class="text-center"><i class="fa fa-spinner"></i></div></div></div>
						<!-- <div class="col-md-12 paddingLR0"><p class="desktopDivider"></p></div> -->
						<div class="col-md-2 paddingLR0">
							<div class="desktopMegamenuSpecialLinks">
								<p class="text-right"><a aria-label="ভিডিও" href="{{url('videos')}}"><i class="fa fa-film fontSize14"></i> ভিডিও</a></p>
								<p class="text-right"><a aria-label="আর্কাইভ" href="{{url('archive')}}"><i class="fa fa-archive fontSize14"></i> আর্কাইভ</a></p>
								<p class="text-right"><a aria-label="সব বিভাগ" href="{{url('categories')}}"><i class="fa fa-table-list fontSize14"></i> সব বিভাগ</a></p>
								<p class="text-right"><a aria-label="বাংলা কনভার্টার" href="{{url('bn-converter')}}" target="_blank"><i class="fa fa-exchange fontSize14"></i> বাংলা কনভার্টার</a></p>
								<p class="text-right"><a aria-label="সোশ্যাল মিডিয়া" href="{{url('links/social-media')}}"><i class="fa fa-thumbs-up fontSize14"></i> সোশ্যাল মিডিয়া</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</nav>
	</div>
	<!-- desktop header end -->


	<!-- mobile header -->
	<div class="container mobileHeader visible-xs hidden-print">
		<div class="col-xs-2">
			<div class="text-left marginT0">
				<span onclick="openNav()" class="mobileClickLoadMenubarCategories"><i class="fa fa-bars sidebarIcon"></i></span>
			</div>
		</div>
		<div class="col-xs-8">
			<div class="marginT3 text-center">
				<a aria-label="Logo" href="{!! url('/') !!}"><img src="{!! asset('uploads/settings/'.$settingsInfo->logo_2) !!}" alt="Logo" height="24"></a>
			</div>
		</div>
		<div class="col-xs-2 paddingL0">
			<div class="text-right marginT0">
				<a aria-label="Search" href="{!! url('search') !!}"><span><i class="fa fa-magnifying-glass searchIcon"></i></span></a>
				<span class="clickToThemeMode colorWhite shadow title1_6"><i class="fa fa-moon"></i></span>
			</div>
		</div>
	</div>

	<!-- mobile sidebar menu -->
	<div id="mySidepanel" class="sidepanel visible-xs hidden-print" onclick="closeNav()">
		<div class="sidebarMainDiv">
			<div class="container borderC1B1 bgBrand">
				<div class="col-xs-12 paddingLR0">
					<div class="text-left displayInlineBlock marginT5 marginB10">
						<a class="sidebarCatTitle border0 colorWhite marginT7 displayInlineBlock shadow1 borderRadius5" style="padding: 2px 10px;" aria-label="ভিডিও" href="{{url('videos')}}">ভিডিও</a>
						<a class="sidebarCatTitle border0 colorWhite marginT7 displayInlineBlock shadow1 borderRadius5" style="padding: 2px 10px;" aria-label="ই-পেপার" href="{{$settingsInfo->another_site}}">ই-পেপার</a>
						
						@if(Auth::check())
						<a class="sidebarCatTitle border0 colorWhite marginT7 displayInlineBlock shadow1 borderRadius5" style="padding: 2px 10px;" aria-label="প্রোফাইল" href="{{url('profile')}}"><i class="fa fa-user-circle" style="font-size: 1.8rem;vertical-align: middle;color: white;"></i></a>
						@else
						<a class="sidebarCatTitle border0 colorWhite marginT7 displayInlineBlock shadow1 borderRadius5" style="padding: 2px 10px;" aria-label="লগইন" href="{{url('login')}}">লগইন</a>
						@endif
					</div>
					<div class="text-right displayInlineBlock pull-right">
						<span href="javascript:void(0)" class="closebtn colorWhite" onclick="closeNav()">×</span>
					</div>
				</div>
			</div>

			<div class="container">
				<div class="col-xs-12 paddingLR0">
					<div class="borderC1-1 shadow1 borderRadius5 marginT15 marginB15 paddingLR20 paddingT10 paddingB10">
						<a class="border0 logoLight" aria-label="Logo" href="{!! url('/') !!}"><img src="{!! asset('uploads/settings/'.$settingsInfo->logo_1) !!}" alt="Logo" class="img-responsive"></a>
						<a style="display: none;" class="border0 logoDark" aria-label="Logo" href="{!! url('/') !!}"><img src="{!! asset('uploads/settings/'.$settingsInfo->logo_2) !!}" alt="Logo" class="img-responsive"></a>
					</div>
				</div>

				<div class="col-xs-6 paddingLR5">
					<a class="sidebarCatTitle" aria-label="প্রচ্ছদ" href="{{url('/')}}"><i class="fa fa-circle"></i> প্রচ্ছদ</a>
				</div>
				<div class="col-xs-6 paddingLR5">
					<a class="sidebarCatTitle" aria-label="সর্বশেষ" href="{{url('/latest')}}"><i class="fa fa-circle"></i> সর্বশেষ</a>
				</div>

				<div class="mobileLoadMenubarCategories"></div>

				<div class="col-xs-6 paddingLR5">
					<a class="sidebarCatTitle" aria-label="সব বিভাগ" href="{!! url('categories') !!}"><i class="fa fa-circle"></i> সব বিভাগ</a>
				</div>
				<div class="col-xs-6 paddingLR5">
					<a class="sidebarCatTitle" aria-label="আর্কাইভ" href="{!! url('archive') !!}"><i class="fa fa-circle"></i> আর্কাইভ</a>
				</div>
				<div class="col-xs-6 paddingLR5">
					<a class="sidebarCatTitle" aria-label="কনভার্টার" href="{!! url('bn-converter') !!}"><i class="fa fa-circle"></i> কনভার্টার</a>
				</div>
			</div>

			<div class="container">
				<div class="col-xs-12 paddingLR0 marginT0 marginB20">
					<div class="topSocialIcon text-center marginT5 borderC1-1 borderRadius5">
						<a aria-label="Facebook" href="{!! $settingsInfo->facebook ? $settingsInfo->facebook : '#' !!}" target="_blank" class="fa fa-brands fa-facebook"></a>
						<a aria-label="Twitter" href="{!! $settingsInfo->twitter ? $settingsInfo->twitter : '#' !!}" target="_blank" class="fa fa-brands fa-x-twitter"></a>
						<a aria-label="Linkedin" href="{!! $settingsInfo->linkedin ? $settingsInfo->linkedin : '#' !!}" target="_blank" class="fa fa-brands fa-linkedin"></a>
						<a aria-label="Instagram" href="{!! $settingsInfo->instagram ? $settingsInfo->instagram : '#' !!}" target="_blank" class="fa fa-brands fa-instagram"></a>
						<a aria-label="Youtube" href="{!! $settingsInfo->youtube ? $settingsInfo->youtube : '#' !!}" target="_blank" class="fa fa-brands fa-youtube"></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- mobile header end -->


	<!-- main div -->
	<div class="mainDiv">
		@yield('content')
	</div>
	<!-- main div end -->


	<!-- desktop footer -->
	<footer class="desktopFooter hidden-xs">
		<div class="container marginT0">
			<div class="row desktopFlexRow">
				<div class="col-sm-12 col-md-12 hidden-print">
					<div class="padding20 marginT20 text-center">
						<a class="logoLight" aria-label="Logo" href="{!! url('/') !!}"><img src="{!! asset('uploads/settings/'.$settingsInfo->logo_1) !!}" alt="Logo" height="30"></a>
						<a class="logoDark" style="display: none;" aria-label="Logo" href="{!! url('/') !!}"><img src="{!! asset('uploads/settings/'.$settingsInfo->logo_2) !!}" alt="Logo" height="30"></a>
					</div>
				</div>
				<div class="col-sm-4 col-md-4 hidden-print">
					<div class="editorDiv h100P">
						<p class="title11 text-center colorBlack">{!! $settingsInfo->publisher !!}</p>
					</div>
				</div>
				<div class="col-sm-4 col-md-4 hidden-print">
					<div class="editorDiv h100P">
						<p class="title11 text-center colorBlack">{!! $settingsInfo->editor !!}</p>
					</div>
				</div>
				<div class="col-sm-4 col-md-4 hidden-print">
					<div class="editorDiv h100P">
						<p class="title11 text-center colorBlack">{!! $settingsInfo->online_head !!}</p>
					</div>
				</div>

				<div class="col-sm-12 col-md-12">
					<div class="footerBottom">
						<div class="linkDiv hidden-print">
							<a class="hoverBlue" aria-label="About" href="{!! url('about') !!}">আমাদের কথা</a>
							<a class="hoverBlue" aria-label="About" href="{!! url('team') !!}">আমরা</a>
							<a class="hoverBlue" aria-label="Contact" href="{!! url('contact') !!}">যোগাযোগ</a>
							<a class="hoverBlue" aria-label="Terms" href="{!! url('terms') !!}">শর্তাবলি ও নীতিমালা</a>
							<a class="hoverBlue" aria-label="Privacy" href="{!! url('privacy-policy') !!}">গোপনীয়তা নীতি</a>
							<a class="hoverBlue" aria-label="Rate Card" href="{!! url('advertisement') !!}">বিজ্ঞাপন মূল্য তালিকা</a>
							<a class="hoverBlue" aria-label="সোশ্যাল মিডিয়া" href="{!! url('links/social-media') !!}">সোশ্যাল মিডিয়া</a>
							<a class="hoverBlue" aria-label="Old Website" rel="nofollow" href="https://old.bangladesherkhabor.net/" target="_blank">পুরোনো সাইট</a>
						</div>	
						
						<div class="footerInfo marginB20">
							<div class="visiblePrintDiv marginT30" style="display: none;">
								<p class="text-center"><img src="{!! asset('uploads/settings/'.$settingsInfo->logo_1) !!}" alt="Logo" height="30"></p>
								<table style="width: 100%;border: none;margin: 0px">
									<tr>
										<td><p class="title11 text-center colorBlack">{!! $settingsInfo->publisher !!}</p></td>
										<td><p class="title11 text-center colorBlack">{!! $settingsInfo->editor !!}</p></td>
										<td><p class="title11 text-center colorBlack">{!! $settingsInfo->online_head !!}</p></td>
									</tr>
								</table>
							</div>
							<p><span class="todaysYear"></span> <i class="fa fa-copyright title1_4"></i> {!! $settingsInfo->newspaper_name_bn !!} কর্তৃক সর্বস্বত্ব স্বত্বাধিকার সংরক্ষিত</p>
							{!! $settingsInfo->footer !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- desktop footer end -->


	<!-- mobile footer -->
	<div class="container marginT50 visible-xs mobileFooter">
		<div class="row">
			<div class="col-xs-12">
				<div class="paddingLR20 paddingT20 marginB5 text-center">
					<a class="logoLight" aria-label="Logo" href="{!! url('/') !!}"><img src="{!! asset('uploads/settings/'.$settingsInfo->logo_1) !!}" alt="Logo" height="25"></a>
					<a class="logoDark" style="display: none;" aria-label="Logo" href="{!! url('/') !!}"><img src="{!! asset('uploads/settings/'.$settingsInfo->logo_2) !!}" alt="Logo" height="25"></a>
				</div>
				<div class="editorDiv">
					<span style="display: inline-block;" class="title2 marginB5 xs-marginB10 bg2 padding5 borderRadius5">{!! $settingsInfo->publisher !!}</span>
					<span style="display: inline-block;" class="title2 marginB5 xs-marginB10 bg2 padding5 borderRadius5">{!! $settingsInfo->editor !!}</span>
					<span style="display: inline-block;" class="title2 marginB5 xs-marginB0 bg2 padding5 borderRadius5">{!! $settingsInfo->online_head !!}</span>
				</div>
				<div class="text-center followDiv hidden-print">
					<div class="topSocialIcon">
						<a aria-label="Facebook" href="{!! $settingsInfo->facebook ? $settingsInfo->facebook : '#' !!}" target="_blank" class="fa fa-brands fa-facebook"></a>
						<a aria-label="Twitter" href="{!! $settingsInfo->twitter ? $settingsInfo->twitter : '#' !!}" target="_blank" class="fa fa-brands fa-x-twitter"></a>
						<a aria-label="Linkedin" href="{!! $settingsInfo->linkedin ? $settingsInfo->linkedin : '#' !!}" target="_blank" class="fa fa-brands fa-linkedin"></a>
						<a aria-label="Instagram" href="{!! $settingsInfo->instagram ? $settingsInfo->instagram : '#' !!}" target="_blank" class="fa fa-brands fa-instagram"></a>
						<a aria-label="Youtube" href="{!! $settingsInfo->youtube ? $settingsInfo->youtube : '#' !!}" target="_blank" class="fa fa-brands fa-youtube"></a>
					</div>
				</div>
				<div class="linkDiv hidden-print">
					<a aria-label="About" href="{!! url('about') !!}">আমাদের কথা</a>
					<a aria-label="About" href="{!! url('team') !!}">আমরা</a>
					<a aria-label="Contact" href="{!! url('contact') !!}">যোগাযোগ</a>
					<a aria-label="Terms" href="{!! url('terms') !!}">শর্তাবলি ও নীতিমালা</a>
					<a aria-label="Privacy" href="{!! url('privacy-policy') !!}">গোপনীয়তা নীতি</a>
					<a aria-label="Rate Card" href="{!! url('advertisement') !!}">বিজ্ঞাপন মূল্য তালিকা</a>
					<a aria-label="সোশ্যাল মিডিয়া" href="{!! url('links/social-media') !!}">সোশ্যাল মিডিয়া</a>
					<a aria-label="Old Website" href="https://old.bangladesherkhabor.net/" rel="nofollow" target="_blank">পুরোনো সাইট</a>
				</div>
				<p class="copyright"><span class="todaysYear"></span> <i class="fa fa-copyright"></i> {!! $settingsInfo->newspaper_name_bn !!} কর্তৃক সর্বস্বত্ব স্বত্বাধিকার সংরক্ষিত</p>
			</div>
		</div>
	</div>
	<!-- mobile footer end -->

	<!-- scroll to top -->
	<span onclick="gotop()" class="go-to-top hidden-print" style="display: none;"><i class="fa fa-angle-up" aria-hidden="true"></i></span>


	<script type="text/javascript" src="{{asset('assets/vendors/jquery/jquery-3.7.1.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/vendors/bootstrap3.7/js/bootstrap.min.js')}}"></script>


	<!-- popup modal ad -->
	<script type="text/javascript">
		$(window).on('load', function() {
			var width = $(window).width();
			if(width <= 768){
				$('#popupModalMobile').modal('show');
				setTimeout(function () {
					$('#popupModalMobile').modal('hide');
				}, 10000);
			}else{
				$('#popupModalDesktop').modal('show');
				setTimeout(function () {
					$('#popupModalDesktop').modal('hide');
				}, 10000);
			}

			$('.popupModalAdCloseButton').click(function(){
				$('#popupModalMobile').modal('hide');
			})
		});
	</script>

	<!-- header fixed -->
	<script type="text/javascript">
		var width = $(window).width();
		if(width >= 768){
			document.addEventListener("DOMContentLoaded", function(){
				window.addEventListener('scroll', function() {
					if (window.scrollY > 100) {
						document.getElementById('navbar_top').classList.add('fixed-top');
						navbar_height = document.querySelector('.navbar').offsetHeight;
						document.body.style.paddingTop = navbar_height + 'px';
						$('.stickyNavMiddleDiv').removeClass('col-md-12');
						$('.stickyNavMiddleDiv').addClass('col-md-9');
						$('.headerMenu').css("text-align", "right");
						$('.stickyNavLeftDiv').addClass('col-md-2');
						$('.stickyNavLeftDiv').show();
						$('.stickyNavRightDiv').addClass('col-md-1');
						$('.stickyNavRightDiv').show();
					} else {
						document.getElementById('navbar_top').classList.remove('fixed-top');
						document.body.style.paddingTop = '0';
						$('.stickyNavMiddleDiv').removeClass('col-md-9');
						$('.stickyNavMiddleDiv').addClass('col-md-12');
						$('.headerMenu').css("text-align", "center");
						$('.stickyNavLeftDiv').removeClass('col-md-2');
						$('.stickyNavLeftDiv').hide();
						$('.stickyNavRightDiv').removeClass('col-md-1');
						$('.stickyNavRightDiv').hide();
					} 
				});
			});
		}
	</script>

	<!-- device wise div remove -->
	<script type="text/javascript">
		var width = $(window).width();
		if(width >= 768){
			$('.visible-xs').remove();
		}
		if(width <= 767){
			$('.hidden-xs').remove();
		}
	</script>


	<!-- megamenu -->
	<script type="text/javascript">
		$('.allMenu').click(function(){
			$('.megaMenu').toggle(100);
			$('.allMenu').toggle();
		});
	</script>

	<!-- sidebar desktop -->
	<script type="text/javascript">
		function openNavDesktop() {
			document.getElementById("desktopSidebar").style.width = "300px";
		}
		function closeNavDesktop() {
			document.getElementById("desktopSidebar").style.width = "0";
		}
	</script>

	<!-- sidebar mobile -->
	<script type="text/javascript">
		function openNav(){
			document.getElementById("mySidepanel").style.width = "100%";
		}
		function closeNav(){
			document.getElementById("mySidepanel").style.width = "0";
		}
	</script>

	<!-- go to top -->
	<script type="text/javascript">
		$(window).scroll(function(){
			if ($(window).scrollTop() > 300) {
				$('.go-to-top').show();
			}else{
				$('.go-to-top').hide();
			}
		});
		function gotop(){
			var scrollStep = -window.scrollY / 300,
			scrollInterval = setInterval(function () {
				if (window.scrollY != 0) {
					window.scrollBy(0, scrollStep);
				} else clearInterval(scrollInterval);
			}, 2);
		}
	</script>

	<!-- jquery onscroll image loader -->
	<script src="{{asset('assets/vendors/loadscroll/jQuery.loadScroll.js')}}"></script>
	<script type="text/javascript">
		$(document).ready(function () { 
			$('img').loadScroll();
		});
	</script>


	<!-- FlexSlider -->
	<script defer src="{{asset('assets/vendors/flex-gallery/jquery.flexslider.js')}}"></script>
	<script type="text/javascript">
		$(function(){
			// SyntaxHighlighter.all();
		});
		$(window).on('load', function(){
			$('.flexslider').flexslider({
				controlNav: false,
				animation: "slide",
				animationLoop: false,
				directionNav: true,
				itemWidth: 320,
				itemMargin: 20,
				pausePlay: true,
				nextText: "",
				prevText: "",
				start: function(slider){
					$('body').removeClass('loading');
				}
			});
		});
	</script>


	<script src="{{asset('assets/vendors/datepicker/bootstrap.min.js')}}"></script>
	<script type="text/javascript">
		$('#datePicker').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true
		});

		$('#selectHeaderDate').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true
		});

		$('#selectHeaderDate').datepicker().on('changeDate', function(e) {
			var selectedDate = e.format(0,"yyyy-mm-dd");
			window.location.href = '{!! url('archive') !!}?date='+selectedDate;
		});
	</script>


	<!-- desktop ajax load menubar categories -->
	<script type="text/javascript">
		$('.desktopClickLoadMenubarCategories').click(function(){
			$('.loadingIcon').show();
			var url = '{{url("ajax/load/menubarcategories")}}';
			$.get(url, function(data){
				if(data != ''){
					$('.desktopLoadMenubarCategories').empty();
					$('.loadingIcon').hide();
					$.each(data, function(key, value){
						$('.loaderDiv1').hide();
						var row = $('<div class="col-md-2 paddingL0"><div class="paddingT5 paddingB7"><a class="title11 textDecorationNone colorBlack hoverBlue" aria-label="'+value.display_name+'" href="{{url('/')}}/'+value.title+'">'+value.display_name+'</a></div></div>');
						$('.desktopLoadMenubarCategories').append(row);
					});
				}
			});
		});
	</script>

	<!-- mobile ajax load menubar categories -->
	<script type="text/javascript">
		$('.mobileClickLoadMenubarCategories').click(function(){
			$('.loadMenubarCategories').toggle();
			$('.loadingIcon').show();
			var url = '{{url("ajax/load/menubarcategories")}}';
			$.get(url, function(data){
				if(data != ''){
					$('.mobileLoadMenubarCategories').empty();
					$('.loadingIcon').hide();
					$.each(data, function(key, value){
						$('.loaderDiv1').hide();
						var row = $('<div class="col-xs-6 paddingLR5"><a class="sidebarCatTitle" aria-label="'+value.display_name+'" href="{{url('/')}}/'+value.title+'"><i class="fa fa-circle"></i> '+value.display_name+'</a></div>');
						$('.mobileLoadMenubarCategories').append(row);
					});
				}
			});
		});
	</script>

	<!-- convert english to bangla -->
	<script type="text/javascript">
		function englishToBangla(val) {
			var EnlishToBanglaNumber = {'PM': 'পিএম', 'AM': 'এএম', '0': '০', '1': '১', '2': '২', '3': '৩', '4': '৪', '5': '৫', '6': '৬', '7': '৭', '8': '৮', '9': '৯', 'Sat': 'শনিবার', 'Sun': 'রবিবার', 'Mon': 'সোমবার', 'Tue': 'মঙ্গলবার', 'Wed': 'বুধবার', 'Thu': 'বৃহস্পতিবার', 'Fri': 'শুক্রবার', 'Jan': 'জানুয়ারি', 'Feb': 'ফেব্রুয়ারি', 'Mar': 'মার্চ', 'Apr': 'এপ্রিল', 'May': 'মে', 'Jun': 'জুন', 'Jul': 'জুলাই', 'Aug': 'আগস্ট', 'Sep': 'সেপ্টেম্বর', 'Oct': 'অক্টোবর', 'Nov': 'নভেম্বর', 'Dec': 'ডিসেম্বর'};
			String.prototype.getDigitBanglaFromEnglish = function() {
				var retStr = this;
				for (var x in EnlishToBanglaNumber) {
					retStr = retStr.replace(new RegExp(x, 'g'), EnlishToBanglaNumber[x]);
				}
				return retStr;
			};
			var english_number = '' + val;
			var bangla_converted_number = english_number.getDigitBanglaFromEnglish();
			return bangla_converted_number;
		}
	</script>

	<!-- convert bangla year -->
	<script type="text/javascript">
		var todaysDate = englishToBangla('{!! date("D, d M Y") !!}');
		$('.todaysDate').html('<i class="fa fa-calendar title1_4"></i> '+todaysDate);
		var todaysYear = englishToBangla('{!! date("Y") !!}');
		$('.todaysYear').html(todaysYear);
	</script>

	<!-- bangla archive -->
	<script type="text/javascript">
		var archiveDays = {'1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯','10':'১০','11':'১১','12':'১২','13':'১৩','14':'১৪','15':'১৫','16':'১৬','17':'১৭','18':'১৮','19':'১৯','20':'২০','21':'২১','22':'২২','23':'২৩','24':'২৪','25':'২৫','26':'২৬','27':'২৭','28':'২৮','29':'২৯','30':'৩০','31':'৩১'};
		$.each(archiveDays, function(key, value){
			$('.archiveDays').append('<option value="'+key+'">'+value+'</option>');
		});

		var archiveMonths = {'1':'জানুয়ারি','2':'ফেব্রুয়ারি','3':'মার্চ','4':'এপ্রিল','5':'মে','6':'জুন','7':'জুলাই','8':'আগস্ট','9':'সেপ্টেম্বর','10':'অক্টোবর','11':'নভেম্বর','12':'ডিসেম্বর'};
		$.each(archiveMonths, function(key, value){
			$('.archiveMonths').append('<option value="'+key+'">'+value+'</option>');
		});

		for (let i = {{date('Y')}}; i >= 2020; i--) {
			$('.archiveYears').append('<option value="'+i+'">'+englishToBangla(i)+'</option>');
		}
	</script>

	<!-- photo gallery progress bar -->
	<script type="text/javascript">
		$('#carousel-example-generic').on('slide.bs.carousel', function(){
			$('.customProgressBar').empty();
			$('.customProgressBar').html('<div class="bar borderRadius0"><div class="in borderRadius0"></div></div>');
		})

		$('.customCarouselPlayButton').click(function () {
			$('#carousel-example-generic').carousel('cycle');
			$('.customCarouselPauseButton').show();
			$('.customCarouselPlayButton').hide();

			$('.customProgressBar').empty();
			$('.customProgressBar').html('<div class="bar borderRadius0"><div class="in borderRadius0"></div></div>');
		});
		$('.customCarouselPauseButton').click(function () {
			$('#carousel-example-generic').carousel('pause');
			$('.customCarouselPauseButton').hide();
			$('.customCarouselPlayButton').show();

			$('.customProgressBar').empty();
		});
	</script>


	<!-- desktop ajax load latest news -->
	<script type="text/javascript">
		var width = $(window).width();
		if(width >= 769){
			$('.latestNewsLoaderDiv').show();
			var url2 = '{{url("ajax/load/latestnews/")}}/10/0/0/30';
			$.get(url2, function(data){
				if(data != ''){
					$('.latestNewsLoaderDiv').hide();
					$.each(data, function(key, value){
						if(value.categoryTitle == 'photos'){
							var icon = '<span class="fa fa-image ppIconSmall"></span>';
						}else if(value.video_code != null){
							var icon = '<span class="fa fa-play pvIconSmall"></span>';
						}else{
							var icon = '';
						}
						var row = $('<div class="media positionRelative paddingLR10"><div class="media-left paddingR5"><div class="positionRelative"><img class="media-object borderRadius5" src="'+value.thumbSmall+'" width="100" alt="'+value.headline+'">'+icon+'</div></div><div class="media-body"><p class="margin0 marginL5 hoverBlue title11">'+value.headline2+'</p></div><a aria-label="'+value.headline+'" href="'+value.url+'" class="linkOverlay"></a></div>');
						$('.ajaxLatestNewsDivDesktop').append(row);
					});				
					$('.latestNewsWidgetDesktop').show();
				}
			});
		}
	</script>

	<!-- mobile ajax load latest news -->
	<script type="text/javascript">
		var width = $(window).width();
		if(width <= 768){
			$('.latestNewsLoaderDiv').show();
			var url2 = '{{url("ajax/load/latestnews/")}}/10/0/0';
			$.get(url2, function(data){
				if(data != ''){
					$('.latestNewsLoaderDiv').hide();
					$.each(data, function(key, value){
						if(value.categoryTitle == 'photos'){
							var icon = '<span class="fa fa-image ppIconSmall"></span>';
						}else if(value.video_code != null){
							var icon = '<span class="fa fa-play pvIconSmall"></span>';
						}else{
							var icon = '';
						}

						var row = $('<div class="media positionRelative paddingLR10"><div class="media-left paddingR5"><div class="positionRelative"><img class="media-object borderRadius5" src="'+value.thumbSmall+'" width="140" alt="'+value.headline+'">'+icon+'</div></div><div class="media-body"><p class="margin0 marginL5 hoverBlue title12">'+value.fullheadline+'</p></div><a aria-label="'+value.headline+'" href="'+value.url+'" class="linkOverlay"></a></div>');
						$('.ajaxLatestNewsDivMobile').append(row);
					});				
					$('.latestNewsWidgetMobile').show();
				}
			});
		}
	</script>

	<!-- desktop ajax load popular news -->
	<script type="text/javascript">
		var width = $(window).width();
		if(width >= 769){
			$('.popularNewsLoaderDiv').show();
			var url2 = '{{url("ajax/load/popularnews/")}}/10/0';
			$.get(url2, function(data){
				if(data != ''){
					$('.popularNewsLoaderDiv').hide();
					$.each(data, function(key, value){
						var number = englishToBangla(parseInt(key+1));
						var row = $('<div class="media positionRelative paddingLR10"><div class="media-left paddingR5"><div class="popularCount">'+number+'</div></div><div class="media-body"><p class="margin0 marginL5 hoverBlue title11">'+value.title+'</p></div><a aria-label="'+value.title+'" href="'+value.link+'" class="linkOverlay"></a></div>');
						$('.ajaxPopularNewsDivDesktop').append(row);
					});				
					$('.popularNewsWidgetDesktop').show();
				}
			});
		}
	</script>

	<!-- mobile ajax load popular news -->
	<script type="text/javascript">
		var width = $(window).width();
		if(width <= 768){
			$('.popularNewsLoaderDiv').show();
			var url2 = '{{url("ajax/load/popularnews/")}}/10/0';
			$.get(url2, function(data){
				if(data != ''){
					$('.popularNewsLoaderDiv').hide();
					$.each(data, function(key, value){
						var number = englishToBangla(parseInt(key+1));
						var row = $('<div class="media positionRelative paddingLR10"><div class="media-left paddingR5"><div class="popularCount">'+number+'</div></div><div class="media-body media-middle"><p class="margin0 marginL5 hoverBlue title12">'+value.title+'</p></div><a aria-label="'+value.title+'" href="'+value.link+'" class="linkOverlay"></a></div>');
						$('.ajaxPopularNewsDivMobile').append(row);
					});				
					$('.popularNewsWidgetMobile').show();
				}
			});
		}
	</script>


	<!-- poll -->
	<script type="text/javascript">
		jQuery(document).ready(function(){
			$(".clickVote").on("change", function(){
				var voteType = $(this).data('votetype');
				var pollId = $(this).data('pollid');
				$.ajax({
					type: 'GET',
					url: '{{URL("poll/store")}}'+"/"+pollId+"/"+voteType,
					success: function (data) {
						if(data != ''){
							$('.clickVoteInput'+pollId).attr('disabled', true);
							$('.totalyesVote'+pollId).html(data.yes_vote_percent_bangla+' %');
							$('.totalNoVote'+pollId).html(data.no_vote_percent_bangla+' %');
							$('.totalNoCommentVote'+pollId).html(data.no_opinion_vote_percent_bangla+' %');
							$('.totalVoter'+pollId).html(data.total_vote_bangla);
						}
					}
				});
			});
		});
	</script>


	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script> -->
	<script type="text/javascript">
		$(".downloadPoll").on('click', function () {
			var pollId = $(this).data('pollid');
			$('.downloadPoll').hide();
			$('.downloadPollShareIcon').hide();
			$('.pollDownloadTime').show();
			var pollDate = $(this).data('polldate');
			html2canvas(document.getElementById("pollContentDiv"+pollId)).then(function (canvas) {
				var anchorTag = document.createElement("a");
				document.body.appendChild(anchorTag);
				anchorTag.download = pollDate+".png";
				anchorTag.href = canvas.toDataURL();
				anchorTag.target = '_blank';
				anchorTag.click();
				$('.downloadPoll').show();
				$('.downloadPollShareIcon').show();
				$('.pollDownloadTime').hide();
			});
		});
	</script>


	<!-- ajax load districts -->
	<script type="text/javascript">
		jQuery(document).ready(function(){
			$(".selectDivision").on("change", function(){
				$('.selectDistrict').empty();
				$('.selectDistrict').append('<option value="">জেলা</option>');
				$('.selectUpazila').empty();
				$('.selectUpazila').append('<option value="">উপজেলা</option>');
				var divisionId = $(this).val();
				var division = $(this).find(':selected').data('division');
				$.ajax({
					type: 'GET',
					url: '{{URL("ajax/load/districts")}}'+"/"+divisionId,
					success: function (data) {
						if(data != ''){
							$.each(data, function(key, value){
								var row = $('<option data-district="'+value.title+'" value="'+value.id+'">'+value.display_name+'</option>');
								$('.selectDistrict').append(row);
							});
							$('.selectDistrict').removeAttr('disabled');
						}
					}
				});
			});
		});
	</script>

	<!-- ajax load upazila -->
	<script type="text/javascript">
		jQuery(document).ready(function(){
			$(".selectDistrict").on("change", function(){
				$('.selectUpazila').empty();
				$('.selectUpazila').append('<option value="">উপজেলা</option>');
				var districtId = $(this).val();
				var district = $(this).find(':selected').data('district');
				$.ajax({
					type: 'GET',
					url: '{{URL("ajax/load/upazilas")}}'+"/"+districtId,
					success: function (data) {
						if(data != ''){
							$.each(data, function(key, value){
								var row = $('<option data-upazila="'+value.title+'" value="'+value.id+'">'+value.display_name+'</option>');
								$('.selectUpazila').append(row);
							});
							$('.selectUpazila').removeAttr('disabled');
						}
					}
				});
			});
		});
	</script>

	<!-- click location search -->
	<script type="text/javascript">
		jQuery(document).ready(function(){
			$('.clickSearchButton').click(function(){
				var topic = $('.selectUpazila').find(':selected').data('upazila');
				if(topic == undefined){
					var topic = $('.selectDistrict').find(':selected').data('district');
				}
				if(topic == undefined){
					var topic = $('.selectDivision').find(':selected').data('division');
				}
				var url = "{{url('area/')}}/"+topic;
				if(topic != undefined){
					window.location.href = url;
				}else{
					$('.searchMessageDiv').show();
				}
			})
		});
	</script>

	<script type="module">
		var themeMode = localStorage.getItem('themeMode');
		if(themeMode == 'dark-mode'){
			var element = document.body;
			element.classList.toggle("dark-mode");
			$('.fa-moon').addClass('fa-sun');
			$('.fa-moon').removeClass('fa-moon');
			$('.logoLight').hide();
			$('.logoDark').show();
		}
		$('.clickToThemeMode').click(function(){
			var element = document.body;
			element.classList.toggle("dark-mode");
			if($("body").hasClass('dark-mode')){
				$('.fa-moon').addClass('fa-sun');
				$('.fa-moon').removeClass('fa-moon');
				$('.logoLight').hide();
				$('.logoDark').show();
				localStorage.setItem('themeMode', 'dark-mode');
			}else{
				$('.fa-sun').addClass('fa-moon');
				$('.fa-sun').removeClass('fa-sun');
				$('.logoLight').show();
				$('.logoDark').hide();
				localStorage.setItem('themeMode', 'light-mode');
			}
		});
	</script>

	@stack('js')

</body>
</html>
