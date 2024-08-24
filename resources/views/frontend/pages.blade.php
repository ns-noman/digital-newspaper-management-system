@extends('layouts.frontend.master')
@section('content')
    <div class="photo-gallery-album-section margin-top-20 margin-bottom-40">
        <div class="container">
            <div class="row">
                <div class="col-md-24">
                    <p>&nbsp;</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-18">
                    <div class="album">
                        {!! $data['pagedetail']['Detail'] !!}
                    </div>
                </div>
                <div class="col-md-6 ads-center-mt">
                    <a href="http://www.maguragroup.com.bd/" target="_blank"> <img class="img-responsive" style="border: solid 1px #ccc;" src="http://epaper.bangladesherkhabor.net/assets/ads/300X250.jpg" alt=""></a>
                </div>
            </div>
        </div>
    </div>
@endsection
