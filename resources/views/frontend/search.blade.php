@extends('layouts.frontend.master')
@section('content')
<div class="photo-gallery-album-section margin-top-20 margin-bottom-40">
    <div class="container">
        <div class="row">
            <div class="col-md-18">
                <div class="album">
                    <h2>ফলাফল</h2>
                    <gcse:search></gcse:search>
                </div>
            </div>
            <div class="col-md-6 ads-center-mt">
                <a href="http://www.maguragroup.com.bd/" target="_blank">
                    <img class="img-responsive" style="border: solid 1px #ccc;" src="http://epaper.bangladesherkhabor.net/assets/ads/300X250.jpg" alt="">
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    (function() {
      var cx = '001503049071094120007:s-s2lqgy_ve';
      var gcse = document.createElement('script');
      gcse.type = 'text/javascript';
      gcse.async = true;
      gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
      var s = document.getElementsByTagName('script')[0];
      s.parentNode.insertBefore(gcse, s);
    })();
  </script>
@endsection
