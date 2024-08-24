<div class="social-section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-8 side-1">
                <a href="{{ route('home.index') }}"><img height="30"
                        src="{{ asset('public/uploads/basic-info/LogoWhite.png') }}" alt="বাংলাদেশের খবর"></a>
            </div>
            <div class="col-md-8 col-sm-8 side-2">
                <ul class="social">
                    <li><a class="facebook" target="_blank" href="{{ $basicInfo->SiteFaceBook }}"><i
                                class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a class="twitter" target="_blank" href="{{ $basicInfo->SiteTwitter }}"><i class="fa fa-twitter"
                                aria-hidden="true"></i></a></li>
                    <li><a class="google-plus" target="_blank" href="{{ $basicInfo->SiteGooglePlus }}"><i
                                class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                    <li><a class="youtube" target="_blank" href="{{ $basicInfo->SiteYouTube }}"><i class="fa fa-youtube"
                                aria-hidden="true"></i></a></li>
                    <li><a class="linkedin" target="_blank" href="{{ $basicInfo->SiteLinkdin }}"><i
                                class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                </ul>
            </div>
            <div class="col-md-8 col-sm-8 side-3">
                <ul class="apps">
                    <li><a href="#"><img alt="ads"
                                src="{{ asset('public/uploads/basic-info/google_play.png') }}"></a></li>
                    <li><a href="#"><img alt="ads"
                                src="{{ asset('public/uploads/basic-info/app_store.png') }}"></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="footer-section">
    <div class="container">
        <div class="row footer-top">
            <div class="col-md-6 col-sm-6 side-1">
                <div class="side-1-inner">
                    <h2>খবর</h2>
                    <div class="row hidden-xs">
                        <div class="col-md-12 col-sm-12">
                            <ul>
                                <li><a href="{{ route('categories.categories', ['todayspaper',1]) }}">আজকের পত্রিকা</a></li>
                                <li><a href="{{ route('categories.categories', ['bangladesh',4]) }}">বাংলাদেশ</a></li>
                                <li><a href="{{ route('categories.categories', ['economy',14]) }}">অর্থনীতি</a></li>
                                <li><a href="{{ route('categories.categories', ['abroad',7]) }}">বিদেশ</a></li>
                                <li><a href="{{ route('categories.categories', ['opinion',6]) }}">মতামত</a></li>
                            </ul>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <ul>
                                <li><a href="{{ route('categories.categories', ['technology',9]) }}">বিজ্ঞান ও প্রযুক্তি</a></li>
                                <li><a href="{{ route('categories.categories', ['sports',12]) }}">খেলা</a></li>
                                <li><a href="{{ route('categories.categories', ['entertainment',16]) }}">বিনোদন</a></li>
                                <li><a href="{{ route('categories.categories', ['life-style',15]) }}">জীবনধারা</a></li>

                            </ul>
                        </div>
                    </div>

                    <div class="row visible-xs">
                        <div class="col-md-24">
                            <ul>
                                <li><a href="{{ route('categories.categories', ['todayspaper',1]) }}">আজকের পত্রিকা</a></li>
                                <li><a href="{{ route('categories.categories', ['bangladesh',4]) }}">বাংলাদেশ</a></li>
                                <li><a href="{{ route('categories.categories', ['economy',14]) }}">অর্থনীতি</a></li>
                                <li><a href="{{ route('categories.categories', ['abroad',7]) }}">বিদেশ</a></li>
                                <li><a href="{{ route('categories.categories', ['opinion',6]) }}">মতামত</a></li>
                                <li><a href="{{ route('categories.categories', ['technology',9]) }}">বিজ্ঞান ও প্রযুক্তি</a></li>
                                <li><a href="{{ route('categories.categories', ['sports',12]) }}">খেলা</a></li>
                                <li><a href="{{ route('categories.categories', ['entertainment',16]) }}">বিনোদন</a></li>
                                <li><a href="{{ route('categories.categories', ['life-style',15]) }}">জীবনধারা</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4  col-sm-4 side-2">
                <div class="side-2-inner">
                    <h2>বিবিধ</h2>
                    <ul>
                        <li><a href="{{ route('fe-pages.index',implode('-',['advertisement',32])) }}">বিজ্ঞাপন</a></li>
                        <li><a href="{{ route('fe-pages.index',implode('-',['circulation',38])) }}">সার্কুলেশন</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-14 col-sm-14">
                <div class="row">
                    <div class="col-md-16 col-sm-24 side-3">
                        <div class="side-3-inner">
                            <h2>যোগাযোগ</h2>
                            <h3>বাংলাদেশের খবর</h3>
                            <p>ভারপ্রাপ্ত সম্পাদক: সৈয়দ মেজবাহ উদ্দিন, প্রকাশক: বাংলাদেশ নিউজ অ্যান্ড এন্টারটেইনমেন্ট
                                লিমিটেড, শ্রীরামপুর, ধামরাই, ঢাকা-এর পক্ষে প্রকাশক কর্তৃক সিটি পাবলিশিং হাউজ, ১
                                আর.কে.মিশন রোড, ঢাকা থেকে মুদ্রিত ও প্রকাশিত। বার্তা ও বাণিজ্যিক কার্যালয়: প্লট
                                নং-৩১৪/এ, রোড-১৮, ব্লক-ই, বসুন্ধরা আ/এ, ঢাকা-১২২৯। পিএবিএক্স : ৫৫০৩৬৪৫৬-৭, ৫৫০৩৬৪৫৮
                                ফ্যাক্স : ৮৪৩১০৯৩ সার্কুলেশন: ০১৮৪৭-৪২১১৫২ বিজ্ঞাপন : ০১৮৪৭-০৯১১৩১, ০১৭৩০-৭৯৩৪৭৮,
                                ০১৮৪৭-৪২১১৫৩, ০১৩২২-৯১০৪২২ Email: newsbnel@gmail.com, বিজ্ঞাপন:
                                bkhaboradvt2021@gmail.com, www.bangladesherkhabor.net, www.bangladesherkhabor.org </p>
                        </div>
                    </div>
                    <div class="col-md-8  col-sm-24 side-4">
                        <div class="side-4-inner">
                            <h2>আমাদের সম্পর্কে</h2>
                            <p>বাংলাদেশ নিউজ অ্যান্ড এন্টারটেইনমেন্ট লিমিটেড এর একটি প্রতিষ্ঠান</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row footer-bottom">
            <div class="col-md-12 col-sm-12 side-1">
                <p>কপিরাইট © বাংলাদেশের খবর</p>
            </div>
            <div class="col-md-12 col-sm-12 side-2 text-right">
                <ul>
                    <li><a href="{{ route('fe-pages.index',implode('-',['privacy-policy',28])) }}">গোপনীয়তার নীতি</a></li>
                    <li>|</li>
                    <li><a href="{{ route('fe-pages.index',implode('-',['terms-conditions',35])) }}">শর্ত ও নিয়মাবলী</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
