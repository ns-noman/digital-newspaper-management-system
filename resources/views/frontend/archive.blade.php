@extends('layouts.frontend.master')
@section('content')
    <div class="archive-section margin-top-20 margin-bottom-40">
        <div class="container">
            <div class="row">
                <div class="col-md-18">
                    <div class="row">
                        <div class="col-md-16">
                            <header class="section-title">
                                <h1 class="box-title">আর্কাইভ:
                                    {{ app('date.formatter')->formatDateInBengali($data['selecteddate']) }}
                                    <span class="hidden-xs">তারিখ নির্বাচন করুন: </span>
                                </h1>
                            </header>
                        </div>
                        <div class="col-md-8 m-margin" style="padding-top:10px;">
                            <form class="form-inline" role="form" method="post" action="{{ route('archives.index') }}">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-sm-6 col-xs-6" style="padding-right: 0;">
                                        <select name="Year" class="form-control" style="padding: 0;  border-radius: 0;">
                                            <option>Year</option>
                                            @for ($i = date('Y'); $i >= 2016; $i--)
                                                <option {{ date('Y') == $i ? 'selected' : '' }} value='{{ $i }}'>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6 col-xs-6" style="padding-right: 0;">
                                        <select name="Month" class="form-control" style="padding: 0;  border-radius: 0;">
                                            <option>Month</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option {{ date('m') == $i ? 'selected' : '' }}
                                                    value='{{ sprintf('%02d', $i) }}'>{{ sprintf('%02d', $i) }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6 col-xs-6">
                                        <select name="Day" class="form-control" style="padding: 0;  border-radius: 0;">
                                            <option>Day</option>
                                            @for ($i = 1; $i <= 31; $i++)
                                                <option {{ date('d') == $i ? 'selected' : '' }}
                                                    value='{{ sprintf('%02d', $i) }}'>{{ sprintf('%02d', $i) }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <input type="submit" class="btn" name="Submit" value="Go" />
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-24">
                            @php
                                $parent_di = [];
                                foreach ($data['categorylistchild'] as $categorylist_child) {
                                    $parent_di[$categorylist_child['ParentID']] = $categorylist_child['ParentID'];
                                }
                                unset($parent_di[30], $parent_di[37]);
                                $ignore = [30, 37];
                            @endphp
                            <form class="form-inline"
                                style="margin-left:20px;    border-bottom: solid 1px #ccc;  padding-bottom: 10px;">
                                <label for="category"> বাছাই করুন : </label>
                                <div class="form-group">
                                    <select class="form-control" id="filter_catagory">
                                        <option value=''>সব খবর ...</option>
                                        @foreach ($data['categorylist'] as $category_list)
                                            @if (!in_array($category_list['ID'], $ignore))
                                                <option value="{{ '_' . $category_list['ID'] . '_' }}">
                                                    {{ $category_list['Name'] }}</option>
                                            @endif
                                        @endforeach
                                        @foreach ($data['categorylistchild'] as $categorylist_child)
                                            @if ($categorylist_child['ParentID'] == $category_list['ID'])
                                                <option value="{{ $categorylist_child['Name'] }}">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;{{ $categorylist_child['Name'] }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                    <ol class="margin archive-news-list" id="list">
                        @foreach ($data['newslist'] as $row)
                            <li>
                                <a href="{{ route('news.news', implode('-', [$row['TileUrl'], $row['id']])) }}"><span
                                        class="time">{{ app('date.formatter2')->toBanglaDigit(date('H:i', strtotime($row['Date']))) }}</span>
                                    <h1 class="title">{{ $row['HomepageTitle'] }}</h1>
                                </a>
                                <p class="hidden">{{ '_' . $row['ParentCategoryID'] . '_' }}{{ $row['CategoryBngName'] }}
                                </p>
                            </li>
                        @endforeach
                    </ol>
                </div>
                <div class="col-md-6">
                    <a href="http://www.maguragroup.com.bd/" target="_blank"> <img class="img-responsive"
                            style="border: solid 1px #ccc;"
                            src="http://epaper.bangladesherkhabor.net/assets/ads/300X250.jpg" alt=""></a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        (function($) {
            jQuery.expr[':'].Contains = function(a, i, m) {
                return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
            };
            function listFilter(list) {
                console.log(list);
                $('#filter_catagory')
                    .change(function() {
                        var filter = $(this).val();
                        if (filter) {
                            $(list).find("p:not(:Contains(" + filter + "))").parent().hide();
                            $(list).find("p:Contains(" + filter + ")").parent().show();
                        } else {
                            $(list).find("li").show();
                        }
                        return false;
                    })
                    .keyup(function() {
                        $(this).change();
                    });
            }
            $(function() {
                listFilter($("#list"));
            });
        }(jQuery));
    </script>
@endsection
