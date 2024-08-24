@extends('layouts.frontend.master')
@section('content')
    <div class="category-section">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home.index') }}"><i class="fa fa-home" aria-hidden="true"></i></a> / {{ $data['category']['Caption'] }}
            </div>
            <div class="row">
                @foreach ($data['newslist']->items() as $key => $row)
                    @if ($key < 3)
                        <div class="col-md-8 col-sm-8 category-top">
                            <div class="image_wrapper">
                                <div class="image image-align-tc" style="display: block; background-image: url('{{ asset('public/uploads/news/' . $row['MediumImage']) }}');">
                                    <a href="{{ route('news.news',implode('-',[$row['TileUrl'],$row['id']])) }}"
                                        data-tb-shadow-region-link="0"></a>
                                </div>
                            </div>
                            <div class="title-cat background-lenear">
                                <p class="top-cat background-lenear-cat">
                                    <a href="{{ route('categories.categories', [$row['CategoryName'],$row['NewsCategoryID']]) }}" data-tb-shadow-region-link="0">{{ $row['CategoryBngName'] }}</a>
                                <h2><a href="{{ route('news.news',implode('-',[$row['TileUrl'],$row['id']])) }}"data-tb-shadow-region-link="0">{{ $row['HomepageTitle'] }}</a>
                                </h2>
                                <ul class="update-comment ">
                                    <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট
                                        {{ app('date.formatter')->formatDateInBengali($row['Date']) }}</li>
                                    <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                                </ul>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="row category-sub-news category-sub-top">
                @foreach ($data['newslist']->items() as $key => $row)
                    @if ($key > 3 && $key < 8)
                        <div class="col-md-6 col-sm-8 {{ $key == 7 ? 'hidden-sm' : '' }}">
                            <div class="sub-image-title">
                                <div class="side-1 padding-right-none">
                                    <div class="image_wrapper">
                                        <div class="image image-align-tc"
                                            style="display: block; background-image: url('{{ asset('public/uploads/news/' . $row['Thumbimage']) }}');">
                                            <a href="{{ route('news.news',implode('-',[$row['TileUrl'],$row['id']])) }}"
                                                data-tb-shadow-region-link="0"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-2">
                                    <p class="sub-cat">
                                        <a href="{{ route('categories.categories', [$row['CategoryName'],$row['NewsCategoryID']]) }}" data-tb-shadow-region-link="0">{{ $row['CategoryBngName'] }}</a>
                                    <p class="sub-title"><a href="{{ route('news.news',implode('-',[$row['TileUrl'],$row['id']])) }}" data-tb-shadow-region-link="0">{{ $row['HomepageTitle'] }}</a></p>
                                    <p class="update"><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter')->formatDateInBengali($row['Date']) }} </p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="row category-sub-news category-sub-bottom">
                @foreach ($data['newslist']->items() as $key => $row)
                    @if ($key > 7 && $key < 12)
                        <div class="col-md-6 col-sm-8 {{ $key == 11 ? 'hidden-sm' : '' }}">
                            <div class="sub-image-title">
                                <div class="side-1 padding-right-none">
                                    <div class="image_wrapper">
                                        <div class="image image-align-tc"
                                            style="display: block; background-image: url('{{ asset('public/uploads/news/' . $row['Thumbimage']) }}');">
                                            <a href="{{ route('news.news',implode('-',[$row['TileUrl'],$row['id']])) }}"
                                                data-tb-shadow-region-link="0"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-2">
                                    <p class="sub-cat">
                                        <a href="{{ route('categories.categories', [$row['CategoryName'], $row['NewsCategoryID']]) }}"
                                            data-tb-shadow-region-link="0">{{ $row['CategoryBngName'] }}</a>
                                    <p class="sub-title"><a
                                            href="{{ route('news.news',implode('-',[$row['TileUrl'],$row['id']])) }}"
                                            data-tb-shadow-region-link="0">{{ $row['HomepageTitle'] }}</a></p>
                                    <p class="update"><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট
                                        {{ app('date.formatter')->formatDateInBengali($row['Date']) }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="row category-more-news">
                <div class="col-md-18">
                    <div class="row">
                        <div class="col-md-18">
                            <h3 class="more-title">{{ $data['category']['Caption'] }}: আরো সংবাদ</h3>
                        </div>
                        <div class="col-md-6 text-right listing-view-action hidden-xs">
                            <span class="list-view"><i class="fa fa-th-list" aria-hidden="true"></i></span>
                            <span class="compact-view"><i class="fa fa-th-large" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    <div class="news-wrapper">
                        @foreach ($data['newslist']->items() as $key => $row)
                            @if ($key > 11 && $key < 20)
                                <div class="item-list {{ $key == 19 ? 'last-list' : '' }}">
                                    <div class="col-sm-6 no-padding photobox">
                                        <div class="more-image">
                                            <div class="image_wrapper">
                                                <div class="image image-align-tc"
                                                    style="display: block; background-image: url('{{ asset('public/uploads/news/' . $row['Thumbimage']) }}');">
                                                    <a href="{{ route('news.news',implode('-',[$row['TileUrl'],$row['id']])) }}"
                                                        data-tb-shadow-region-link="0"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-18 photobox">
                                        <div class="more-details">
                                            <h3><a href="{{ route('news.news',implode('-',[$row['TileUrl'],$row['id']])) }}"
                                                    data-tb-shadow-region-link="0">{{ $row['HomepageTitle'] }}</a></h3>
                                            <ul class="update-comment">
                                                <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট
                                                    {{ app('date.formatter')->formatDateInBengali($row['Date']) }}</li>
                                                <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                                            </ul>
                                            <p>@wordLimiter($row['NewsSummary'], 60, '&nbsp;').....<a class="btn-detail-ponno" href="{{ route('news.news',implode('-',[$row['TileUrl'],$row['id']])) }}">বিস্তারিত</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="text-center">
                        <div class="d-flex justify-content-center m-1">
                            {!! $data['newslist']->onEachSide(1)->links() !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-24 industry-business">
                    <div class="ads-center-mt">
                        <a href="http://www.maguragroup.com.bd/" target="_blank"> <img class="img-responsive"
                                style="border: solid 1px #ccc;"
                                src="http://epaper.bangladesherkhabor.net/assets/ads/300X250.jpg" alt=""></a>
                    </div>
                    @if(isset($data['childcatagory'][0]['id']) && isset($data['newslist1'][0]['id']))
                        <h2><a href="{{ route('categories.categories', [$data['childcatagory'][0]['SEOCaption'], $data['childcatagory'][0]['id']]) }}" data-tb-shadow-region-link="0">{{ $data['childcatagory'][0]['Caption'] }}</a>
                        </h2>
                        <div class="industry-business-top">
                            <div class="image_wrapper">
                                <div class="image image-align-tc"
                                    style="display: block; background-image: url('{{ asset('public/uploads/news/' . $data['newslist1'][0]['Thumbimage']) }}');">
                                    <a href="{{ route('news.news',implode('-',[$data['newslist1'][0]['TileUrl'], $data['newslist1'][0]['id']])) }}" data-tb-shadow-region-link="0"></a>
                                </div>
                            </div>
                            <div class="title-cat background-lenear">
                                <h2> <a href="{{ route('news.news',implode('-',[$data['newslist1'][0]['TileUrl'], $data['newslist1'][0]['id']])) }}" data-tb-shadow-region-link="0">{{ $data['newslist1'][0]['HomepageTitle'] }}</a></h2>
                                <ul class="update-comment ">
                                    <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter')->formatDateInBengali($data['newslist1'][0]['Date']) }}</li>
                                    <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                                </ul>
                            </div>
                        </div>
                        <p>@wordLimiter($data['newslist1'][0]['NewsSummary'], 50, '&nbsp;')</p>
                    @endif
                </div>
            </div>
            <div class="row ads">
                <div class="col-md-8 ads-three">
                    <a href="http://www.maguragroup.com.bd/" target="_blank"><img class="img-responsive" style="border: solid 1px #ccc;" src="http://epaper.bangladesherkhabor.net/assets/ads/373X93.jpg" alt=""></a>
                </div>
                <div class="col-md-8 ads-three">
                    <a href="http://www.maguragroup.com.bd/" target="_blank"><img class="img-responsive" style="border: solid 1px #ccc;" src="http://epaper.bangladesherkhabor.net/assets/ads/373X93.jpg" alt=""></a>
                </div>
                <div class="col-md-8 ads-three">
                    <a href="http://www.maguragroup.com.bd/" target="_blank"><img class="img-responsive" style="border: solid 1px #ccc;" src="http://epaper.bangladesherkhabor.net/assets/ads/373X93.jpg" alt=""></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-18 col-sm-24">
                    @if(isset($data['childcatagory'][1]['id']) && isset($data['newslist2'][0]['id']))
                        <h2><a href="{{ route('categories.categories', [$data['childcatagory'][1]['SEOCaption'],$data['childcatagory'][1]['id']]) }}" data-tb-shadow-region-link="0">{{ $data['childcatagory'][1]['Caption'] }}</a></h2>
                        <div class="row grameen-economic-top">
                            @foreach($data['newslist2'] as $key=>$row)
                                @if($key<2)
                                    <div class="col-md-12 col-sm-12 grameen-economic">
                                        <div class="image_wrapper">
                                            <div class="image image-align-tc"
                                                style="display: block; background-image: url('{{ asset('public/uploads/news/' . $row['Thumbimage']) }}');">
                                                <a href="{{ route('news.news',implode('-',[$row['TileUrl'],$row['id']])) }}" data-tb-shadow-region-link="0"></a>
                                            </div>
                                        </div>
                                        <div class="title-cat background-lenear">
                                            <h2><a href="{{ route('news.news',implode('-',[$row['TileUrl'],$row['id']])) }}" data-tb-shadow-region-link="0">{{ $row['HomepageTitle'] }}</a></h2>
                                            <ul class="update-comment ">
                                                <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter')->formatDateInBengali($row['Date']) }}</li>
                                                <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="row grameen-economic-top">
                            @foreach($data['newslist2'] as $key=>$row)
                                @if($key >1 && $key < 4)
                                    <div class="col-md-12 col-sm-12 grameen-economic">
                                        <div class="image_wrapper">
                                            <div class="image image-align-tc"
                                                style="display: block; background-image: url('{{ asset('public/uploads/news/' . $row['Thumbimage']) }}');">
                                                <a href="{{ route('news.news',implode('-',[$row['TileUrl'],$row['id']])) }}" data-tb-shadow-region-link="0"></a>
                                            </div>
                                        </div>
                                        <div class="title-cat background-lenear">
                                            <h2><a href="{{ route('news.news',implode('-',[$row['TileUrl'],$row['id']])) }}" data-tb-shadow-region-link="0">{{ $row['HomepageTitle'] }}</a></h2>
                                            <ul class="update-comment ">
                                                <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter')->formatDateInBengali($row['Date']) }}</li>
                                                <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-md-6 col-sm-24 industry-business">
                    @if(isset($data['childcatagory'][2]['id']) && isset($data['newslist3'][0]['id']))
                        <h2><a href="{{ route('categories.categories', [$data['childcatagory'][2]['SEOCaption'],$data['childcatagory'][2]['id']]) }}" data-tb-shadow-region-link="0">{{ $data['childcatagory'][2]['Caption'] }}</a></h2>
                        <div class="industry-business-top">
                            <div class="image_wrapper">
                                <div class="image image-align-tc" style="display: block; background-image: url('{{ asset('public/uploads/news/' . $data['newslist3'][0]['Thumbimage']) }}');">
                                    <a href="{{ route('news.news',implode('-',[$data['newslist3'][0]['TileUrl'], $data['newslist3'][0]['id']])) }}" data-tb-shadow-region-link="0"></a>
                                </div>
                            </div>
                            <div class="title-cat background-lenear">
                                <h2><a href="{{ route('news.news',implode('-',[$data['newslist3'][0]['TileUrl'], $data['newslist3'][0]['id']])) }}" data-tb-shadow-region-link="0">{{ $data['newslist3'][0]['HomepageTitle'] }}</a></h2>
                                <ul class="update-comment ">
                                    <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter')->formatDateInBengali($data['newslist3'][0]['Date']) }}</li>
                                    <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                                </ul>
                            </div>
                        </div>
                        <p>@wordLimiter($data['newslist3'][0]['NewsSummary'], 60, '&nbsp;')</p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-12  ponno-bazar">
                    @if(isset($data['childcatagory'][3]['id']) && isset($data['newslist4'][0]['id']))
                        <h2>   <a href="{{ route('categories.categories', [$data['childcatagory'][3]['SEOCaption'],$data['childcatagory'][3]['id']]) }}" data-tb-shadow-region-link="0">{{ $data['childcatagory'][3]['Caption'] }}</a></h2>
                        <div class="row ponno-bazar-top">
                            <div class="col-md-12 col-sm-12">
                                <div class="image_wrapper">
                                    <div class="image image-align-tc"
                                        style="display: block; background-image: url('{{ asset('public/uploads/news/' . $data['newslist4'][0]['Thumbimage']) }}');">
                                        <a href="{{ route('news.news',implode('-',[$data['newslist4'][0]['TileUrl'], $data['newslist4'][0]['id']])) }}" data-tb-shadow-region-link="0"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <h3><a href="{{ route('news.news',implode('-',[$data['newslist4'][0]['TileUrl'], $data['newslist4'][0]['id']])) }}" data-tb-shadow-region-link="0">{{ $data['newslist4'][0]['HomepageTitle'] }}</a></h3>
                                <ul class="update-comment">
                                    <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter')->formatDateInBengali($data['newslist4'][0]['Date']) }}</li>
                                    <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                                </ul>
                                <p>@wordLimiter($data['newslist4'][0]['NewsSummary'], 12, '......')<a class="btn-detail-ponno" href="{{ route('news.news',implode('-',[$data['newslist4'][0]['TileUrl'], $data['newslist4'][0]['id']])) }}">বিস্তারিত</a>
                                </p>
                            </div>
                        </div>
                        <div class="ponno-bazar-bottom">
                            @for($i=0; $i<=3; $i++)
                                <div class="row ponno-bazar-line">
                                    @foreach($data['newslist4'] as $key=>$row)
                                        @if($key >= $i*2 && $key < $i*2+2)
                                            <div class="col-md-12 col-sm-12 padding-right-10">
                                                <div class="row ponno-bazar-line-half">
                                                    <div class="col-md-10 col-xs-10 col-sm-10 padding-right-10">
                                                        <div class="image_wrapper">
                                                            <div class="image image-align-tc"
                                                                style="display: block; background-image: url('{{ asset('public/uploads/news/' . $row['Thumbimage']) }}');">
                                                                <a href="{{ route('news.news',implode('-',[$row['TileUrl'],$row['id']])) }}" data-tb-shadow-region-link="0"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-14 col-sm-14 col-xs-14 padding-left-10">
                                                        <h3><a href="{{ route('news.news',implode('-',[$row['TileUrl'],$row['id']])) }}" data-tb-shadow-region-link="0">{{ $row['HomepageTitle'] }}</a></h3>
                                                        <ul class="update-comment">
                                                            <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট
                                                                {{ app('date.formatter')->formatDateInBengali($row['Date']) }}</li>
                                                            <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endfor
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    @if(isset($data['childcatagory'][4]['id']) && isset($data['newslist5'][0]['id']))
                        <h2><a href="{{ route('categories.categories', [$data['childcatagory'][4]['SEOCaption'],$data['childcatagory'][4]['id']]) }}">{{  $data['childcatagory'][4]['Caption'] }}</a></h2>
                        @foreach($data['newslist5'] as $key=>$row)
                            <div class="others">
                                <div class="image_wrapper">
                                    <div class="image image-align-tc"
                                        style="display: block; background-image: url('{{ asset('public/uploads/news/' . $row['Thumbimage']) }}');">
                                        <a href="{{ route('news.news',implode('-',[$row['TileUrl'],$row['id']])) }}" data-tb-shadow-region-link="0"></a>
                                    </div>
                                </div>
                                <div class="title-cat background-lenear">
                                    <h2><a href="{{ route('news.news',implode('-',[$row['TileUrl'],$row['id']])) }}" data-tb-shadow-region-link="0">{{ $row['HomepageTitle'] }}</a></h2>
                                    <ul class="update-comment ">
                                        <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট {{ app('date.formatter')->formatDateInBengali($row['Date']) }}</li>
                                        <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
