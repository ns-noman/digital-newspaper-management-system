@extends('layouts.frontend.master')
@section('content')
    <div class="pollresult-section photo-gallery-album-section online-poll-section margin-top-20 margin-bottom-40">
        <div class="container">
            <div class="row">
                <div class="col-md-18">
                    <div class="album">
                        <h2>জরিপ ফলাফল</h2>
                        <div class="row">
                            @foreach ($data['onlinepoll'] as $key => $row)
                                @php
                                    $yes = $row['PositiveComment'];
                                    $no = $row['NegativeComment'];
                                    $nocomment = $row['NoComment'];
                                    $total = $yes + $no + $nocomment;
                                    if ($total > 0) {
                                        $yes = round(($yes / $total) * 100, 2);
                                        $no = round(($no / $total) * 100, 2);
                                        $nocomment = round(($nocomment / $total) * 100, 2);
                                    }
                                @endphp
                                <div class="col-md-24 poll-item">
                                    <h4>{{ $row['Caption'] }}</h4>
                                    <p>মতামত দিয়েছেন:: {{ $total }} জন </p>
                                    <strong>হ্যাঁ</strong><span class="pull-right">{{ $yes }}%</span>
                                    <div class="progress progress-danger active">
                                        <div class="bar" style="width: {{ $yes }}%;"></div>
                                    </div>
                                    <strong>না</strong><span class="pull-right">{{ $no }}%</span>
                                    <div class="progress progress-success active">
                                        <div class="bar" style="width: {{ $no }}%;"></div>
                                    </div>
                                    <strong>মন্তব্য নেই</strong><span class="pull-right">{{ $nocomment }}%</span>
                                    <div class="progress progress-warning active">
                                        <div class="bar" style="width: {{ $nocomment }}%;"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-6 ads-center-mt">
                    <a href="http://www.maguragroup.com.bd/" target="_blank">
                        <img class="img-responsive" style="border: solid 1px #ccc;"
                            src="http://epaper.bangladesherkhabor.net/assets/ads/300X250.jpg" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
