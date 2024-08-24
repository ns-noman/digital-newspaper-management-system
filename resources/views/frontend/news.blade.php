@extends('layouts.frontend.master')
@section('content')
<div class="detail-latest-section" id="detail-page">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home.index') }}"><i class="fa fa-home" aria-hidden="true"></i></a> /
            <a href="{{ route('categories.categories', [$data['detailnews']['CategoryName'], $data['detailnews']['NewsCategoryID']]) }}">{{ $data['detailnews']['CategoryBngName'] }}</a> / {{ $data['detailnews']['NewsTitle'] }}
        </div>
        <div class="row">
            <div class="col-md-18">
                <div class="detail-top">
                    <div class="demo-content cf">
                        <div class="picture three cf">
                            <figure itemscope itemtype="http://schema.org/ImageObject">
                                <a data-caption="{{ $data['detailnews']['ImageTitle'] }}"  href="{{ asset('public/uploads/news/'. $data['detailnews']['Image']) }}"  itemprop="contentUrl" data-size="1000x667">
                                    <img src="{{ asset('public/uploads/news/'. $data['detailnews']['Image'])  }}" class="img-responsive" itemprop="thumbnail" alt="{{ $data['detailnews']['ImageTag'] }}">
                                </a>
                                <i class="fa fa-expand expand" aria-hidden="true"></i>
                                <figcaption class="caption">
                                    @if($data['detailnews']['CaptionHeading'])
                                        <div class="side-1">
                                            <h2>{{ $data['detailnews']['CaptionHeading'] }}</h2>
                                        </div>
                                    @endif
                                    <div class="side-2">
                                        <h3>{{ $data['detailnews']['ImageTitle'] }}</h3>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="detail-heading" data-article-id="{{ $data['detailnews']['id'] }}">
                    <p class="detail-cat">{{ $data['detailnews']['CategoryBngName'] }}</p>
                    <h3 class="sub-title">{{ $data['detailnews']['NewsShoulder'] }}</h3>
                    <h2 class="title">{{ $data['detailnews']['NewsTitle'] }}</h2>
                    <h3 class="sub-title padding-bottom-10">{{ $data['detailnews']['NewsHanger'] }}</h3>
                    <div class="row">
                        <div class="col-md-16 col-sm-16 col-xs-24">
                            <ul class="writer-info">
                                <li>
                                    @php
                                        $image = (isset($data['reporterinfo']['Image']) && $data['reporterinfo']['Image'] != null) ? $data['reporterinfo']['Image']: 'default.png';
                                        $src = asset("public/uploads/reporters/".$image);
                                    @endphp
                                    <img class="img-circle" width="58" height="58" src="{{ $src }}" alt="">
                                </li>
                                @isset($data['detailnews']['ReporterName'])
                                    <li class="writer">{{ $data['detailnews']['ReporterName'] }}</li>
                                @endisset
                                <li><i class="fa fa-clock-o clock" aria-hidden="true"></i> প্রকাশিত {{ app('date.formatter')->formatDateInBengali($data['detailnews']['Date']) }}</li>
                            </ul>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-24">
                            <div class="text-right social">
                                <p class="align-middle">
                                    <a target="_blank" href="{{ route('news.print', $data['detailnews']['id']) }}"><i class="fa fa-print fa-2x"></i></a>
                                    <a target="_blank" href="" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('{{ url()->full() }}'),'facebook-share-dialog','width=626,height=436'); return false;"><i class="fa fa-facebook-square fa-2x"></i></a>
                                    <a target="_blank" href="" onclick="javascript:window.open('https://twitter.com/share?text={{ $data["title"] }}&amp;url={{ url()->full() }}','Twitter-dialog','width=626,height=436'); return false;"><i class="fa fa-twitter-square fa-2x"></i></a>
                                    <a target="_blank" href="" onclick="window.open('https://plus.google.com/share?url={{ url()->full() }}','Google-dialog','width=626,height=436'); return false;"><i class="fa fa-google-plus-square fa-2x"></i></a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="detail-content">
                    <article>
                        @php
                            function prefix_insert_post_ads($content, $ad_code, $position) {
                                    return prefix_insert_after_paragraph($ad_code, $position, $content);
                                }

                                function prefix_insert_after_paragraph($insertion, $paragraph_id, $content) {
                                    $closing_p = '</p>';
                                    $paragraphs = explode($closing_p, $content);
                                    foreach ($paragraphs as $index => $paragraph) {
                                        if (trim($paragraph)) {
                                            $paragraphs[$index] .= $closing_p;
                                        }
                                        if ($paragraph_id == $index + 1) {
                                            $paragraphs[$index] .= $insertion;
                                        }
                                    }
                                    return implode('', $paragraphs);
                                }

                                function nl2p($string) {
                                    $paragraphs = '';
                                    foreach (explode("\n", $string) as $line) {
                                        if (trim($line)) {
                                            $paragraphs .= '<p>' . $line . '</p>';
                                        }
                                    }
                                    return $paragraphs;
                                }
                                $post = $data['newsdescription'];
                                
                                $ad_code1 = '';
                                $afterfirstad = prefix_insert_post_ads($post, $ad_code1, 2);
                                echo $afterfirstad;
                        @endphp
                    </article>
                    @if(count($data['realtednews']) > 0)
                        <div class="underlined">
                            <h2>রিলেটেড সংবাদ:</h2>
                            <ol>
                                @foreach($data['realtednews'] as $key=>$row)
                                    <li> <a target="_blank" href="{{ route('news.news',implode('-',[$row['TileUrl'],$row['id']])) }}">{{ $row['NewsTitle'] }}</a></li>
                                @endforeach
                            </ol>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-8 social-bottom">
                        <div class="text-left social">
                            <a target="_blank" href="" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent('{{ url()->full() }}'),'facebook-share-dialog','width=626,height=436'); return false;"><i class="fa fa-facebook-square fa-2x"></i></a>
                            <a target="_blank" href="" onclick="javascript:window.open('https://twitter.com/share?text={{ $data['title'] }}&amp;url={{ url()->full() }}','Twitter-dialog','width=626,height=436'); return false;"><i class="fa fa-twitter-square fa-2x"></i></a>
                            <a target="_blank" href="" onclick="window.open('https://plus.google.com/share?url={{ url()->full() }}','Google-dialog','width=626,height=436'); return false;"><i class="fa fa-google-plus-square fa-2x"></i></a>
                        </div>
                    </div>
                </div>
                <span class="disqus-comment-count" data-disqus-url="{{ url()->full() }}"> <!-- Count will be inserted here --> </span>
                <div class="row">
                    <div class="col-md-24 social-bottom">
                        <ul class="pager">
                            @if(isset($data['newsprev']['id']))
                                <li class="previous"><a href="{{ route('news.news',implode('-',[$data['newsprev']['TileUrl'],$data['newsprev']['id']])) }}">&larr; পূর্ববর্তী সংবাদ </a></li>  
                            @endif
                            @if(isset($data['newsnext']['id']))
                                <li class="next"><a href="{{ route('news.news',implode('-',[$data['newsnext']['TileUrl'],$data['newsnext']['id']])) }}">পরবর্তী সংবাদ  &rarr;</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-24 social-bottom">
                        <div id="disqus_thread"></div>
                        <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                    </div>
                </div>
                <h3>আরও পড়ুন</h3>
                <div class="row">
                    @foreach($data['othernews'] as $key=>$row)
                        @if($key<4)
                            <div class="col-md-6 more-news">
                                <div class="image_wrapper">
                                    <div class="image image-align-tc" style="display: table-cell;">
                                        <a target="_blank" href="{{ route('news.news',implode('-',[$row['TileUrl'],$row['id']])) }}">
                                            <img class="img-responsive" src="{{ asset('public/uploads/news/'. $row['Thumbimage'])  }}" alt="{{ $row['NewsTitle'] }}">
                                        </a>
                                    </div>
                                </div>
                                <div class="more-news-title">
                                    <a target="_blank" href="{{ $row['CategoryName']."/".$row['id']."?".($row['TileUrl']) }}">
                                        <h3>{{ $row['NewsTitle'] }}</h3>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
				<br><br>
                <div class="row">
                    @foreach($data['othernews'] as $key=>$row)
                        @if($key>3 && $key<8)
                            <div class="col-md-6 more-news">				
                                <div class="image_wrapper">
                                    <div class="image image-align-tc" style="display: block; background-image: url('{{ asset('public/uploads/news/'. $row['Thumbimage'])  }}');" >
                                        <a href="{{ route('news.news',implode('-',[$row['TileUrl'],$row['id']])) }}" data-tb-shadow-region-link="0"></a>
                                    </div>
                                </div>
                                <div class="title-cat background-lenear">
                                    <p class="top-cat"><a href="{{ route('categories.categories', [$row['CategoryName'],$row['NewsCategoryID']]) }}">{{ $row['CategoryBngName'] }}</a>
                                    <h2><a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}">{{ $row['HomepageTitle'] }}</a></h2>
                                    <ul class="update-comment ">
                                        <li><i class="fa fa-clock-o" aria-hidden="true"></i> আপডেট  {{ $row['Date'] }}</li>
                                        <!--<li><i class="fa fa-comment-o" aria-hidden="true"></i> ৪ মন্তব্য</li>-->
                                    </ul>
                                </div>				
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
				<div class="detail-latest">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home">সর্বশেষ</a></li>
                        <li><a data-toggle="tab" href="#menu1">সর্বাধিক পঠিত</a></li>
                        <li><a data-toggle="tab" href="#menu2">আলোচিত</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            @foreach($data['latestNews'] as $key=>$row)
                                <div class="latest-news hover-effect">
                                    <div class="side-1 padding-right-none">
                                        <div class="image_wrapper">
                                            <div class="image image-align-tc"
                                                style="display: block; background-image: url('{{ asset('public/uploads/news/'. $row['Thumbimage'])  }}');">
                                                <a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}" data-tb-shadow-region-link="0"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="side-2">
                                        <p><a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}">{{ $row['HomepageTitle'] }}</a></p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div id="menu1" class="tab-pane fade">
                            @foreach($data['topread'] as $key=>$row)
                                <div class="latest-news hover-effect">
                                    <div class="side-1 padding-right-none">
                                        <div class="image_wrapper">
                                            <div class="image image-align-tc"
                                                style="display: block; background-image: url('{{ asset('public/uploads/news/'. $row['Thumbimage'])  }}');">
                                                <a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}" data-tb-shadow-region-link="0"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="side-2">
                                        <p><p><a href="{{ route('news.news',implode('-',[$row['TileUrl'], $row['id']])) }}">{{ $row['HomepageTitle'] }}</a></p></p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div id="menu2" class="tab-pane fade">
                        </div>
                    </div>
                </div>
                <div class="ads-center-mt">
                    <a href="http://www.maguragroup.com.bd/" target="_blank"> <img class="img-responsive"
                            style="border: solid 1px #ccc;" src="{{ asset('public/uploads/ads/300X600-ndl.jpg') }}"
                            alt=""></a>
                </div>
                <div class="ads-center-mt">
                    <a href="http://www.maguragroup.com.bd/" target="_blank"> <img class="img-responsive"
                            style="border: solid 1px #ccc;" src="{{ asset('public/uploads/ads/300X600-ndl.jpg') }}"
                            alt=""></a>
                </div>
			</div>
        </div>    
    </div>
</div>

<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true" style="">

    <div class="pswp__bg"></div>
    <div class="pswp__scroll-wrap">

        <div class="pswp__container" style="transform: translate3d(0px, 0px, 0px);">
            <div class="pswp__item" style="display: block; transform: translate3d(-1511px, 0px, 0px);"><div class="pswp__zoom-wrap" style="transform: translate3d(262px, 44px, 0px) scale(0.824588);"><img class="pswp__img" src="img/office-1.jpg" alt="img fullscreen" style="backface-visibility: hidden; opacity: 1;"></div></div>
            <div class="pswp__item" style="transform: translate3d(0px, 0px, 0px);"><div class="pswp__zoom-wrap" style="transform: translate3d(262px, 44px, 0px) scale(0.824588);"><img class="pswp__img" src="img/office-2.jpg" alt="img fullscreen" style="backface-visibility: hidden; opacity: 1; display: block;"></div></div>
            <div class="pswp__item" style="display: block; transform: translate3d(1511px, 0px, 0px);"><div class="pswp__zoom-wrap" style="transform: translate3d(262px, 44px, 0px) scale(0.824588);"><img class="pswp__img" src="img/office-3.jpg" alt="img fullscreen" style="backface-visibility: hidden; opacity: 1;"></div></div>
        </div>

        <div class="pswp__ui pswp__ui--fit pswp__ui--hidden">

            <div class="pswp__top-bar">

                <div class="pswp__counter">2 / 3</div>

                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                <button class="pswp__button pswp__button--share" title="Share"></button>
                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                      <div class="pswp__preloader__cut">
                        <div class="pswp__preloader__donut"></div>
                      </div>
                    </div>
                </div>
            </div>

            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div> 
            </div>

            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>

            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(function() {
        window.disqus_config = function() {
            this.page.url = "{{ url()->full() }}"; // Replace PAGE_URL with your page's canonical URL variable
            this.page.identifier = this.page.url.split('-').at(-1); // Replace PAGE_IDENTIFIER with your page's unique identifier variable
            this.callbacks.onNewComment = [function(comment) {
                var data = comment;
                data.article_id = $('[data-article-id]').attr('data-article-id');
                data._token = "{{ csrf_token() }}";
                $.ajax({
                    method: 'POST',
                    url: '{{ route("news.comment") }}',
                    data: data,
                    timeout: 10000,
                    success: function(result) {
                        console.log(result);
                    }
                });
            }];
        };
        var d = document,
            s = d.createElement('script');
        s.src = 'https://bangladesh-news.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
        visitor();
    });
    function visitor() {
        var pageUrl = "{{ url()->full() }}";
        var news_id = pageUrl.split('-').at(-1);
        $.ajax({
            url: "{{ route('news.visitnum') }}",
            method: "POST",
            data: {
                news_id: news_id,
                _token: "{{ csrf_token() }}"
            },
            dataType: "JSON",
            success: function(result) {
                console.log(result);
            }
        });
    }
</script>
@endsection