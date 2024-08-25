@extends('layouts.frontend.master')
@section('content')
@if(isset($data['breaking']) && count($data['breaking'])>0)
    <div class="breaking-news-section">
        <div class="container">
            <div class="breaking">
                <p class="btn btn-breaking pull-left text-center">ব্রেকিং <i class="fa fa-angle-double-right" aria-hidden="true"></i></p>
                <div class="breaking-link pull-right">
                    <marquee onMouseOver="this.stop()" onMouseOut="this.start()">
                        @foreach($data['breaking'] as $row)
                            <a href="{{ route('news.news',implode('-',[$row['TileUrl'],$row['id']])) }}">{{ $row['HomepageTitle'] }}</a>
                        @endforeach
                    </marquee>
                </div>
            </div>
        </div>
    </div>
@endif
<div class="main-news-section">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-7 col-lg-7">
            </div>
            <div class="col-xs-12 col-md-12 col-lg-12">
            </div>

        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-sm-16 top-news">
                <div class="image_wrapper">
                    <div class="image image-align-tc" style="display: block; background-image: url('{{ asset('public/uploads/news/'.$data['leadNews'][0]['MediumImage']) }}');">
                        <a href="{{ route('news.news',implode('-',[$data['leadNews'][0]['TileUrl'], $data['leadNews'][0]['id']])) }}" data-tb-shadow-region-link="0"></a>
                    </div>
                </div>
                <div class="title-cat background-lenear">
                    <p class="top-cat background-lenear-cat">
                        <a href="{{ route('categories.categories',[$data['leadNews'][0]['CategoryName'], $data['leadNews'][0]['NewsCategoryID']]) }}">{{ $data['leadNews'][0]['CategoryBngName'] }}</a>
                    </p>
                    <p class="shoulder">{{ $data['leadNews'][0]['NewsShoulder'] }}</p>
                    <h2>
                        <a href="{{ route('news.news',implode('-',[$data['leadNews'][0]['TileUrl'], $data['leadNews'][0]['id']])) }}">{{ $data['leadNews'][0]['HomepageTitle'] }}</a>
                    </h2>
                    <p class="hanger">{{ $data['leadNews'][0]['NewsHanger'] }}</p>
                    <ul class="update-comment">
                        <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ date('H:i', strtotime($data['leadNews'][0]['Date'])) }}</li>
                        <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                    </ul>
                </div>
            </div>
            <div class="col-sm-8 visible-sm hidden-xs">
                @if(time() > strtotime('2018-03-15 00:00:00') && time() < strtotime('2018-03-16 00:00:00'))
                    <a href="http://www.bdg-magura.com/home-page/1" target="_blank">
                        <img src="assets/ads/AmaraSokahotFinal.jpg" alt="">
                    </a>
                    <p>&nbsp;</p>
                    <img class="responsive" src="https://dummyimage.com/307x110/cccccc/fff&text=advertisement" alt="">
                @endif
            </div>
            <div class="col-md-6 col-sm-24 sub-news">
                <div class="row">
                    @foreach($data['leadNews'] as $key => $row)
                        @if($key > 0 && $key < 5)
                            <div class="col-md-24 col-sm-6 col-xs-12 {{ $key == 3 ? 'sub-news-mobile' : '' }}">
                                <div class="sub-image-title {{ $key == 4 ? 'last-sub-mews' : '' }}">
                                    <div class="side-1 padding-right-none">
                                        <div class="image_wrapper">
                                            <div class="image image-align-tc" style="display: block; background-image: url('{{ asset('public/uploads/news/'.$row['Thumbimage']) }}');">
                                                <a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}" data-tb-shadow-region-link="0"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="side-2">
                                        <p class="sub-cat"><a href="{{ route('categories.categories', [$row['CategoryName'],$row['NewsCategoryID']]) }}">{{ $row['CategoryBngName'] }}</a></p>
                                        <p class="sub-title"><a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}">{{  $row['HomepageTitle'] }}</a></p>
                                        <p class="update"><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ date('H:i', strtotime($data['leadNews'][0]['Date'])) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-md-4 col-sm-24" style="display:none">
                @foreach($data['editorchoice'] as $key => $row)
                    @if($key < 3)
                        <div class="special-news">
                            <div class="image_wrapper">
                                <div class="image image-align-tc" style="display: block; background-image: url('{{ asset('public/uploads/news/'.$row['Thumbimage']) }}');">
                                    <a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}" data-tb-shadow-region-link="0"></a>
                                </div>
                            </div>
                            <div class="special-title-cat background-lenear">
                                <p class="special-cat background-lenear-cat"><a href="{{ route('categories.categories', [$row['CategoryName'],$row['NewsCategoryID']]) }}" data-tb-shadow-region-link="0">{{ $row['CategoryBngName'] }}</a></p>
                                <p class="special-title">
                                    <a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}" data-tb-shadow-region-link="0">{{ $row['HomepageTitle'] }}</a></p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="col-md-6 ad-sm visible-lg visible-md hidden-sm visible-xs">
                @if (time() > strtotime('2018-03-15 00:00:00') && time() < strtotime('2018-03-16 00:00:00'))
                    <div class="row">
                        <div class="col-md-24 col-sm-12">
                            <a>
                                <img class="img-responsive" src="assets/ads/AmaraSokahotFinal.jpg" alt="">
                            </a>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-24 col-sm-12">
                            <a href="https://www.facebook.com/profile.php?id=61556775981607&mibextid=LQQJ4d" target="_blank">
                                <img src="{{ asset('public/uploads/ads/Image_ads.jpeg') }}/" alt="ads" width="310px">
                            </a>
                        </div>
                        <div class="col-md-24 col-sm-12 ad-sm ad-sm2">
                            <!-- <img src="assets/images/dinparibarton.jpg"> -->
                            <!-- <a href="https://www.facebook.com/nagaddeal" target="_blank"> <img class="img-responsive" style="border: solid 1px #ccc;" src="assets/images/ndl.jpg" alt=""></a> -->
                            </br>
                            <!-- <a href="https://3chaxo.com" rel=dofollow>FREE PLAY SLOTXO</a> -->
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="selected-news-section">
    <div class="container">
        <div class="row">
            <!-- Main Content Column -->
            <div class="col-md-18">
                <!-- Section for Selected News -->
                <section id="">
                    <div class="">
                        <div class="row">
                            @foreach($data['selected'] as $key => $row)
                                <div class="col-md-6" style="margin-bottom:10px">
                                    <div class="">
                                        <div class="selected-news">
                                            <div class="image_wrapper">
                                                <div class="image image-align-tc" style="display: block; background-image: url('{{ asset("public/uploads/news/".$row['Thumbimage']) }}');">
                                                    <a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}" data-tb-shadow-region-link="0"></a>
                                                </div>
                                            </div>
                                            <div class="selected-title-cat background-lenear" style="display:none">
                                                <p class="selected-cat background-lenear-cat">
                                                    <a href="{{ route('categories.categories', [$row['CategoryName'],$row['NewsCategoryID']]) }}">{{  $row['CategoryBngName'] }}</a></p>
                                                <p class="selected-title">
                                                    <a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}">{{  $row['HomepageTitle'] }}</a></p>
                                                <ul class="update-comment">
                                                    <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট 
                                                        {{ app('date.formatter')->formatDateInBengali($row['Date']) }}</li>
                                                </ul>
                                            </div>
                                            <h4><a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}">{{  $row['HomepageTitle'] }}</a></h4>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
                <br>
                <!-- Carousel Ads -->
                <div class="row carousel-ads hidden-sm">
                    <div class="col-md-12 ads-center-mt">
                        <a href="http://www.maguragroup.com.bd/" target="_blank">
                            <img class="img-responsive" style="border: solid 1px #ccc;" src="http://epaper.bangladesherkhabor.net/assets/ads/442X69.jpg" alt="">
                        </a>
                    </div>
                    <div class="col-md-12 ads-center-mt">
                        <a href="http://www.maguragroup.com.bd/" target="_blank">
                            <img class="img-responsive" style="border: solid 1px #ccc;" src="http://epaper.bangladesherkhabor.net/assets/ads/442X69.jpg" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <!-- Sidebar Column -->
            <div class="col-md-6">
                <div class="row">
                    <!-- Online Poll -->
                    <div class="col-md-24 col-sm-12">
                        <div class="online-poll">
                            <h2><a href="{{ route('online-polls.result') }}">জরিপ</a></h2>
                            <div class="poll-content">
                                <p>{{ $data['onlinepoll']['Caption'] }}</p>
                                <form>
                                    <input id="poll_id" type="hidden" value="{{ rand(1000, 9999) . $data['onlinepoll']['id'] . rand(1000, 9999) }}">
                                    <label class="radio-inline">
                                        <input type="radio" name="OnlinePoll" value="Positive">হ্যাঁ
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="OnlinePoll" value="Negative">না
                                    </label>
                                </form>
                                <div class="vote-bottom text-left">
                                    <div class="side-1 pollbutton">
                                        <a class="btn btn-vote onlinepoll" href="##">ভোট দিন</a>
                                    </div>
                                    <div class="side-2 vote-result text-right">
                                        <a href="{{ route('online-polls.result') }}">ফলাফল</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Carousel Ads (Visible on Small Screens) -->
                    <div class="col-sm-12 visible-sm">
                        <div class="row carousel-ads">
                            <div class="col-md-12 ads-center-mt">
                                <a href="http://www.maguragroup.com.bd/" target="_blank">
                                    <img class="img-responsive" style="border: solid 1px #ccc;" src="http://epaper.bangladesherkhabor.net/assets/ads/442X69.jpg" alt="">
                                </a>
                            </div>
                            <div class="col-md-12 ads-center-mt">
                                <a href="http://www.maguragroup.com.bd/" target="_blank">
                                    <img class="img-responsive" style="border: solid 1px #ccc;" src="http://epaper.bangladesherkhabor.net/assets/ads/442X69.jpg" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="gallery-latest-section">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-sm-10 latest-news">
                <div class="latest">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home">সর্বশেষ</a></li>
                        <li><a data-toggle="tab" href="#menu1">সর্বাধিক পঠিত</a></li>
                        <li><a data-toggle="tab" href="#menu2">আলোচিত</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <div class="latest-top">
                                <div class="side-1 padding-right-none">
                                    <div class="image_wrapper">
                                        <div class="image image-align-tc"
                                            style="display: block; background-image: url('{{ asset('public/uploads/news/'. $data['recent'][0]['Thumbimage']) }}');">
                                            <a href="{{ route('news.news',implode('-',[$data['recent'][0]['TileUrl'], $data['recent'][0]['id']])) }}" data-tb-shadow-region-link="0"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-2">
                                    <h3>
                                        <a href="{{ route('news.news',implode('-',[$data['recent'][0]['TileUrl'], $data['recent'][0]['id']])) }}">{{ $data['recent'][0]['HomepageTitle'] }}</a>
                                    </h3>
                                    <p>@wordLimiter($data['recent'][0]['NewsSummary'])</p>
                                </div>
                            </div>
                            <ul class="news-list">
                                @foreach($data['recent'] as $key=>$row)
                                    @if($key>0)
                                        <li>
                                            <a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}">{{ $row['HomepageTitle'] }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            <a class="latest-all text-right" href="{{ route('archives.index') }}">সব খবর</a>
                        </div>
                        <div id="menu1" class="tab-pane fade">
                            <ul class="news-list">
                                @foreach($data['topread'] as $key=>$row)
                                    <li>
                                        <a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}">{{ $row['HomepageTitle'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <a class="latest-all text-right" href="{{ 'mostread' }}">সব খবর</a>
                        </div>
                        <div id="menu2" class="tab-pane fade">
                            <ul class="news-list">
                                @foreach($data['topcomment'] as $key=>$row)
                                    <li>
                                        <a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}">{{ $row['HomepageTitle'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <a class="latest-all text-right" href="{{ 'mostcomment' }}">সব খবর</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-14 col-sm-14 gallery gallery-text">
                <!-- Gallery Section code gallery.txt file -->
                <a href="http://www.maguragroup.com.bd/bdc/download/Brochure_Ready_Plot_December_2012.pdf"
                    target="_blank">
                    <img class="img-responsive" src="{{ asset('public/uploads/basic-info/Ready_Plot.jpg') }}" alt="">
                </a>
            </div>
        </div>
    </div>
</div>
<div class="bangladesh-foreighn-section">
    <div class="container">
        <div class="row">
            <div class="col-md-16 col-sm-14 bangladesh">
                <div class="bangladesh-top">
                    <h2>
                        <a href="{{ 'bangladesh/4' }}">বাংলাদেশ</a>
                    </h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="image_wrapper">
                                <div class="image image-align-tc"
                                    style="display: block; background-image: url('{{ asset('public/uploads/news/'. $data['recent'][0]['Thumbimage']) }}');">
                                    <a href="{{ route('news.news', implode('-',[$data['bangladesh'][0]['TileUrl'], $data['bangladesh'][0]['id']])) }}" data-tb-shadow-region-link="0"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h3>
                                <a href="{{ route('news.news', implode('-',[$data['bangladesh'][0]['TileUrl'], $data['bangladesh'][0]['id']])) }}">{{ $data['bangladesh'][0]['HomepageTitle'] }}</a>
                            <ul class="update-comment">
                                <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter')->formatDateInBengali($data['bangladesh'][0]['Date']) }}</li>
                                <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                            </ul>
                            <p>@wordLimiter($data['bangladesh'][0]['NewsSummary'])</p>
                            <a class="btn btn-detail" href="{{ route('news.news', implode('-',[$data['bangladesh'][0]['TileUrl'], $data['bangladesh'][0]['id']])) }}">বিস্তারিত</a>
                        </div>
                    </div>
                </div>
                <div class="bangladesh-bottom">
                    @foreach($data['bangladesh'] as $key=>$row) 
                        @if($key>0 & $key<3)
                            <div class="side-{{ $key }}">
                                <div class="side-{{ $key }}-left">
                                    <div class="image_wrapper">
                                        <div class="image image-align-tc"
                                            style="display: block; background-image: url('{{ asset('public/uploads/news/'. $row['Thumbimage']) }}');">
                                            <a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}" data-tb-shadow-region-link="0"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-{{ $key }}-right">
                                    <h3><a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}" data-tb-shadow-region-link="0">{{ $row['HomepageTitle'] }}</a></h3>
                                    <ul class="update-comment">
                                        <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter')->formatDateInBengali($row['Date']) }}</li>
                                        <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                                    </ul>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="row bangladesh-bottom hidden-xs hidden-sm">
                    @foreach($data['bangladesh'] as $key=>$row)
                        @if($key>2 & $key<5)
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="image_wrapper">
                                            <div class="image image-align-tc"
                                                style="display: block; background-image: url('{{ asset('public/uploads/news/'. $row['Thumbimage']) }}');">
                                                <a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}" data-tb-shadow-region-link="0"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-14">
                                        <h3><a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}" data-tb-shadow-region-link="0">{{ $row['HomepageTitle'] }}</a></h3>
                                        <ul class="update-comment">
                                            <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter')->formatDateInBengali($row['Date']) }}</li>
                                            <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-md-8 col-sm-10 foreighn">
                <h2><a href="{{ route('categories.categories', ['abroad', 7]) }}" data-tb-shadow-region-link="0">বিদেশ</a></h2>
                <div class="image_wrapper">
                    <div class="image image-align-tc"
                        style="display: block; background-image: url('{{ asset('public/uploads/news/'. $data['world'][0]['Thumbimage']) }}');">
                        <a href="{{ route('news.news',implode('-',[$data['world'][0]['TileUrl'], $data['world'][0]['id']])) }}" data-tb-shadow-region-link="0"></a>
                    </div>
                </div>
                <h3><a href="{{ route('news.news',implode('-',[$data['world'][0]['TileUrl'], $data['world'][0]['id']])) }}" data-tb-shadow-region-link="0">{{ $data['world'][0]['HomepageTitle'] }}</a>
                <ul class="update-comment">
                    <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter')->formatDateInBengali($data['world'][0]['Date']) }}</li>
                    <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                </ul>
                <p>@wordLimiter($data['world'][0]['NewsSummary'],12)</p>
                <ul class="news-list">
                    @foreach($data['world'] as $key=>$row)
                        @if($key>0)
                            <li>
                                <a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}" data-tb-shadow-region-link="0">{{ $row['HomepageTitle'] }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="economic-free-section">
    <div class="container">
        <div class="row">
            <div class="col-md-16 col-sm-14 economic">
                <h2>
                    <a href="{{ route('categories.categories', ['economy', 14]) }}" data-tb-shadow-region-link="0">অর্থ ও বাণিজ্য</a>
                <div class="row">
                    <div class="col-md-14 top-news economic-news">
                        <div class="image_wrapper">
                            <div class="image image-align-tc"
                                style="display: block; background-image: url('{{ asset('public/uploads/news/'. $data['economy'][0]['Thumbimage']) }}');">
                                <a href="{{ route('news.news',implode('-',[$data['economy'][0]['TileUrl'], $data['economy'][0]['id']])) }}" data-tb-shadow-region-link="0"></a>
                            </div>
                        </div>
                        <div class="title-cat background-lenear">
                            <p class="top-cat background-lenear-cat"><a href="{{ route('categories.categories', [$data['economy'][0]['CategoryName'], $data['economy'][0]['NewsCategoryID']]) }}" data-tb-shadow-region-link="0">{{ $data['economy'][0]['CategoryBngName'] }}</a></p>
                            <h2>
                                <a href="{{ route('news.news',implode('-',[$data['economy'][0]['TileUrl'], $data['economy'][0]['id']])) }}" data-tb-shadow-region-link="0">{{ $data['economy'][0]['HomepageTitle'] }}</a>
                            </h2>
                            <ul class="update-comment">
                                <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter')->formatDateInBengali($data['economy'][0]['Date']) }}</li>
                                <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <ul class="news-list">
                            @foreach($data['economy'] as $key=>$row)
                                @if($key>0)
                                    <li>
                                        <a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}" data-tb-shadow-region-link="0">{{ $row['HomepageTitle'] }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-10">
                <div class="free">
                    <h2> <a href="{{ route('categories.categories', ['opinion', 6]) }}" data-tb-shadow-region-link="0">মতামত</a></h2>
                    @if(count($data['opinion'][0]) > 0)
                        <div class="image_wrapper">
                            <div class="image image-align-tc" style="display: block; background-image: url('{{ asset('public/uploads/news/'. $data['opinion'][0]['Thumbimage'] ) }}');">
                                <a href="{{ route('news.news',implode('-',[$data['opinion'][0]['TileUrl'], $data['opinion'][0]['id']])) }}" data-tb-shadow-region-link="0"></a>
                            </div>
                        </div>
                        <h3>
                            <a href="{{ route('news.news',implode('-',[$data['opinion'][0]['TileUrl'], $data['opinion'][0]['id']])) }}" data-tb-shadow-region-link="0">{{ $data['opinion'][0]['HomepageTitle'] }}</a>
                        </h3>
                        <ul class="update-comment">
                            <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter')->formatDateInBengali($data['opinion'][0]['Date']) }}</li>
                            <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                        </ul>
                        <p>@wordLimiter($data['opinion'][0]['NewsSummary'],12)</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="science-sports-section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-12 science">
                <h2><a href="{{ route('categories.categories', ['technology', 67]) }}" data-tb-shadow-region-link="0">বিজ্ঞান ও প্রযুক্তি</a></h2>
                <div class="image_wrapper">
                    <div class="image image-align-tc"
                        style="display: block; background-image: url('{{ asset('public/uploads/news/'. $data['tech'][0]['Thumbimage']) }}');">
                        <a href="{{ route('news.news',implode('-',[$data['tech'][0]['TileUrl'], $data['tech'][0]['id']])) }}" data-tb-shadow-region-link="0"></a>
                    </div>
                </div>
                <h3>
                    @if(isset($data['tech'][0]['id']))
                        <a href="{{ route('news.news',implode('-',[$data['tech'][0]['TileUrl'], $data['tech'][0]['id']])) }}" data-tb-shadow-region-link="0">{{ $data['tech'][0]['HomepageTitle'] }}</a>
                    @endif
                </h3>
                @if(isset($data['tech'][0]['Date']))
                    <ul class="update-comment">
                        <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter')->formatDateInBengali($data['tech'][0]['Date']) }}</li>
                        <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                    </ul>
                @endif

                <ul class="news-list">
                    @foreach($data['tech'] as $key=>$row)
                        @if($key>0)
                            <li>
                                <a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}" data-tb-shadow-region-link="0">{{ $row['HomepageTitle'] }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="col-md-16 col-sm-12 sports">
                <h2> <a href="{{ route('categories.categories', ['sports', 12]) }}" data-tb-shadow-region-link="0">খেলার মাঠে</a></h2>
                <div class="row sports-top">
                    <div class="col-md-13">
                        <div class="image_wrapper">
                            <div class="image image-align-tc"
                                style="display: block; background-image: url('{{ asset('public/uploads/news/'. $data['sports'][0]['Thumbimage']) }}');">
                                <a href="{{ route('news.news',implode('-',[$data['sports'][0]['TileUrl'], $data['sports'][0]['id']])) }}" data-tb-shadow-region-link="0"></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-11">
                        <h3>
                            <a href="{{ route('news.news',implode('-',[$data['sports'][0]['TileUrl'], $data['sports'][0]['id']])) }}" data-tb-shadow-region-link="0">{{ $data['sports'][0]['HomepageTitle'] }}</a>
                        </h3>

                        <ul class="update-comment">
                            <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter')->formatDateInBengali($data['sports'][0]['Date']) }}</li>
                            <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                        </ul>
                        <p>@wordLimiter($data['sports'][0]['NewsSummary'], 30,'&nbsp;')</p>
                        <a class="btn btn-detail" href="{{ route('news.news',implode('-',[$data['sports'][0]['TileUrl'], $data['sports'][0]['id']])) }}">বিস্তারিত</a>
                    </div>
                </div>
                <div class="row sports-bottom">
                    @foreach($data['sports'] as $key=>$row)
                        @if($key>0)
                            <div class="col-md-12">
                                <div class="image_wrapper hidden-sm">
                                    <div class="image image-align-tc"
                                        style="display: block; background-image: url('{{ asset('public/uploads/news/'. $row['Thumbimage']) }}');">
                                        <a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}" data-tb-shadow-region-link="0"></a>
                                    </div>
                                </div>
                                <h3>
                                    <a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}" data-tb-shadow-region-link="0">{{ $row['HomepageTitle'] }}</a>
                                </h3>
                                <ul class="update-comment bottom-border">
                                    <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter')->formatDateInBengali($row['Date']) }}</li>
                                    <!-- <li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                                </ul>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="entertainment-life-style-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-16">
                <div class="entertainment">
                    <h2><a href="{{ route('categories.categories', ['entertainment', 39]) }}" data-tb-shadow-region-link="0">আনন্দ বিনোদন</a></h2>
                    <div class="row">
                        <div class="col-md-12 col-sm-14 entertainment-top">
                            <div class="image_wrapper">
                                <div class="image image-align-tc" style="display: block; background-image: url('{{ asset('public/uploads/news/'. $data['entertainment'][0]['Thumbimage']) }}');">
                                        <a href="{{ route('news.news',implode('-',[$data['entertainment'][0]['TileUrl'], $data['entertainment'][0]['id']])) }}" data-tb-shadow-region-link="0"></a>
                                </div>
                            </div>
                            <h3>
                                <a href="{{ route('news.news',implode('-',[$data['entertainment'][0]['TileUrl'], $data['entertainment'][0]['id']])) }}" data-tb-shadow-region-link="0">{{ $data['entertainment'][0]['HomepageTitle'] }}</a>
                            </h3>
                            <ul class="update-comment">
                                <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter2')->toBanglaDigit($data['entertainment'][0]['Date']) }}</li>
                                <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                            </ul>
                        </div>

                        <div class="col-sm-10 visible-sm">
                            @foreach($data['entertainment']  as $key=>$row)
                                @if($key > 0 && $key <5)
                                <div class="entertainment-list">
                                    <h3>
                                        <a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}" data-tb-shadow-region-link="0">{{ $row['HomepageTitle'] }}</a>
                                    </h3>
                                    <ul class="update-comment">
                                        <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter2')->toBanglaDigit($row['Date']) }}</li>
                                        {{-- <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter2')->toBanglaDigit($row['Date']) }}
                                        </li> --}}
                                        <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                                    </ul>
                                </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="col-md-12 hidden-sm entertainment-top">
                            <div class="image_wrapper">
                                <div class="image image-align-tc" style="display: block; background-image: url('{{ asset('public/uploads/news/'. $data['entertainment'][1]['Thumbimage']) }}');">
                                    <a href="{{ route('news.news',implode('-',[$data['entertainment'][1]['TileUrl'], $data['entertainment'][1]['id']])) }}" data-tb-shadow-region-link="0"></a>
                                </div>
                            </div>
                            <h3>
                            <a href="{{ route('news.news',implode('-',[$data['entertainment'][1]['TileUrl'], $data['entertainment'][1]['id']])) }}" data-tb-shadow-region-link="0">{{ $data['entertainment'][1]['HomepageTitle'] }}</a>
                            <ul class="update-comment">
                                <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter2')->toBanglaDigit($data['entertainment'][1]['Date']) }}</li>
                                <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                            </ul>
                        </div>
                    </div>
                    <div class="row hidden-sm">
                        <div class="col-md-12">
                            <div class="image_wrapper">
                                <div class="image image-align-tc"
                                    style="display: block; background-image: url('{{ asset('public/uploads/news/'. $data['entertainment'][2]['Thumbimage']) }}');">
                                    <a href="{{ route('news.news',implode('-',[$data['entertainment'][2]['TileUrl'], $data['entertainment'][2]['id']])) }}" data-tb-shadow-region-link="0"></a>
                                </div>
                            </div>
                            <h3>
                            <a href="{{ route('news.news',implode('-',[$data['entertainment'][2]['TileUrl'], $data['entertainment'][2]['id']])) }}" data-tb-shadow-region-link="0">{{ $data['entertainment'][2]['HomepageTitle'] }}</a>
                            <ul class="update-comment">
                                <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter2')->toBanglaDigit($data['entertainment'][2]['Date']) }}</li>
                                <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                            </ul>
                        </div>
                        <div class="col-md-12">
                            @if(isset($data['entertainment'][3]['id']))
                                <div class="image_wrapper">
                                    <div class="image image-align-tc"
                                        style="display: block; background-image: url('{{ asset('public/uploads/news/'. $data['entertainment'][3]['Thumbimage']) }}');">
                                        <a href="{{ route('news.news',implode('-',[$data['entertainment'][3]['TileUrl'], $data['entertainment'][3]['id']])) }}" data-tb-shadow-region-link="0"></a>
                                    </div>
                                </div>
                                <h3>
                                    <a href="{{ route('news.news',implode('-',[$data['entertainment'][3]['TileUrl'], $data['entertainment'][3]['id']])) }}" data-tb-shadow-region-link="0">{{ $data['entertainment'][3]['HomepageTitle'] }}</a>
                                <ul class="update-comment">
                                    <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter2')->toBanglaDigit($data['entertainment'][3]['Date']) }}</li>
                                    <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-8">
                <div class="entertainment">
                    <h2>
                        <a href="{{ route("categories.categories",['entertainment',39]) }}" data-tb-shadow-region-link="0">-</a>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="image_wrapper">
                                <div class="image image-align-tc"
                                    style="display: block; background-image: url('{{ asset('public/uploads/news/'. $data['entertainment'][2]['MediumImage']) }}');">
                                    <a href="{{ route('news.news',implode('-',[$data['entertainment'][2]['TileUrl'], $data['entertainment'][2]['id']])) }}" data-tb-shadow-region-link="0"></a>
                                </div>
                            </div>
                            <ul class="news-list">
                                @foreach($data['entertainment'] as $key=>$row)
                                    <li>
                                        <a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}" data-tb-shadow-region-link="0">{{ $row['HomepageTitle'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-12 hidden-xs hidden-sm ads-center-mt">
                            <a href="http://www.koresbd.com/" target="_blank">
                                <img class="img-responsive" style="border: solid 1px #ccc;" src="http://www.bangladesherkhabor.net/assets/images/300X600-ndl.jpg" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="entertainment-life-style-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-16">
                <div class="life-style">
                    <h2><a href="{{ route("categories.categories",['life-style',15]) }}">জীবনধারা</a>
                    <div class="row">
                        <div class="col-md-12 col-sm-14 entertainment-top">
                            <div class="image_wrapper">
                                <div class="image image-align-tc"
                                    style="display: block; background-image: url('{{ asset('public/uploads/news/'. $data['life'][0]['Thumbimage']) }}');">
                                    <a href="{{ route('news.news',implode('-',[$data['life'][0]['TileUrl'], $data['life'][0]['id']])) }}" data-tb-shadow-region-link="0"></a>
                                </div>
                            </div>
                            <h3>
                                <a href="{{ route('news.news',implode('-',[$data['life'][0]['TileUrl'], $data['life'][0]['id']])) }}" data-tb-shadow-region-link="0">{{ $data['life'][0]['HomepageTitle'] }}</a>
                            <ul class="update-comment">
                                <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter')->formatDateInBengali($data['life'][0]['Date']) }}</li>
                                <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                            </ul>
                        </div>

                        <div class="col-sm-10 visible-sm">
                            @foreach($data['life']  as $key=>$row)
                                @if($key > 0 && $key <5)
                                    <div class="entertainment-list">
                                        <h3>
                                            <a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}" data-tb-shadow-region-link="0">{{ $row['HomepageTitle'] }}</a>
                                        </h3>
                                        <ul class="update-comment">
                                            <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter')->formatDateInBengali($row['Date']) }}
                                            </li>
                                            <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                                        </ul>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-md-12 hidden-sm entertainment-top">
                            <div class="image_wrapper">
                                <div class="image image-align-tc"
                                    style="display: block; background-image: url('{{ asset('public/uploads/news/'. $data['life'][1]['Thumbimage']) }}');">
                                    <a href="{{ route('news.news',implode('-',[$data['life'][1]['TileUrl'], $data['life'][1]['id']])) }}" data-tb-shadow-region-link="0"></a>
                                </div>
                            </div>
                            <h3>
                                <a href="{{ route('news.news',implode('-',[$data['life'][1]['TileUrl'], $data['life'][1]['id']])) }}" data-tb-shadow-region-link="0">{{ $data['life'][1]['HomepageTitle'] }}</a>
                            </h3>
                            <ul class="update-comment">
                                <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter')->formatDateInBengali($data['life'][1]['Date']) }}</li>
                                <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                            </ul>
                        </div>
                    </div>
                    <div class="row hidden-sm">
                        <div class="col-md-12">
                            <div class="image_wrapper">
                                <div class="image image-align-tc"
                                    style="display: block; background-image: url('{{ asset('public/uploads/news/'. $data['life'][2]['Thumbimage']) }}');">
                                    <a href="{{ route('news.news',implode('-',[$data['life'][2]['TileUrl'], $data['life'][2]['id']])) }}" data-tb-shadow-region-link="0"></a>
                                </div>
                            </div>
                            <h3>
                                <a href="{{ route('news.news',implode('-',[$data['life'][2]['TileUrl'], $data['life'][2]['id']])) }}" data-tb-shadow-region-link="0">{{ $data['life'][2]['HomepageTitle'] }}</a>
                            <ul class="update-comment">
                                <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter')->formatDateInBengali($data['life'][2]['Date']) }}</li>
                                <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                            </ul>
                        </div>
                        <div class="col-md-12">
                            @if(isset($data['life'][3]['id']))
                                <div class="image_wrapper">
                                    <div class="image image-align-tc"
                                        style="display: block; background-image: url('{{ asset('public/uploads/news/'. $data['life'][3]['Thumbimage']) }}');">
                                        <a href="{{ route('news.news',implode('-',[$data['life'][3]['TileUrl'], $data['life'][3]['id']])) }}" data-tb-shadow-region-link="0"></a>
                                    </div>
                                </div>
                                <h3>
                                    <a href="{{ route('news.news',implode('-',[$data['life'][3]['TileUrl'], $data['life'][3]['id']])) }}" data-tb-shadow-region-link="0">{{ $data['life'][3]['HomepageTitle'] }}</a>
                                <ul class="update-comment">
                                    <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter')->formatDateInBengali($data['life'][3]['Date']) }}</li>
                                    <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-8">
                <div class="life-style">
                    <h2>
                        <a href="{{ route("categories.categories",['life-style',15]) }}" data-tb-shadow-region-link="0">-</a>
                    </h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="image_wrapper">
                                <div class="image image-align-tc"
                                    style="display: block; background-image: url('{{ asset('public/uploads/news/'. $data['life'][4]['MediumImage']) }}');">
                                    <a href="{{ route('news.news',implode('-',[$data['life'][4]['TileUrl'], $data['life'][4]['id']])) }}" data-tb-shadow-region-link="0">-</a>
                                </div>
                            </div>
                            <ul class="news-list">
                                @foreach($data['life'] as $key=>$row)
                                    <li>
                                        <a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}" data-tb-shadow-region-link="0">{{ $row['HomepageTitle'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-12 hidden-xs hidden-sm ads-center-mt">
                            <a href="https://www.facebook.com/nagaddeal" target="_blank"> <img class="img-responsive"
                                    style="border: solid 1px #ccc;"
                                    src="http://www.bangladesherkhabor.net/assets/images/300X600.jpg"
                                    alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
