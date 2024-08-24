<script async custom-element="amp-auto-ads" src="https://cdn.ampproject.org/v0/amp-auto-ads-0.1.js"></script>
<script type="text/javascript"
    src="//platform-api.sharethis.com/js/sharethis.js#property=59d88a6fa397b70018a01624&product=inline-share-buttons">
</script>
<script src="{{ asset('public/frontend-assets') }}/js/jquery.min.js"></script>
<script src="{{ asset('public/frontend-assets') }}/js/bootstrap.min.js"></script>
<script src="{{ asset('public/frontend-assets') }}/js/owl.carousel.js"></script>
<!-- Core JS file -->
<script src="{{ asset('public/frontend-assets') }}/zoom/photoswipe.min.js"></script>
<!-- UI JS file -->
<script src="{{ asset('public/frontend-assets') }}/zoom/photoswipe-ui-default.min.js"></script>
<!-- Date Conversion Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/xsoh/moment-hijri/moment-hijri.js"></script>

<script>
    function convertToBengaliNumber(num) {
        const bengaliNumbers = {
            '0': '০',
            '1': '১',
            '2': '২',
            '3': '৩',
            '4': '৪',
            '5': '৫',
            '6': '৬',
            '7': '৭',
            '8': '৮',
            '9': '৯',
            '.': '.'
        };
        return num.toString().split('').map(digit => bengaliNumbers[digit]).join('');
    }

    function getBangladeshiBengaliDate() {
        const banglaMonths = ['বৈশাখ', 'জ্যৈষ্ঠ', 'আষাঢ়', 'শ্রাবণ', 'ভাদ্র', 'আশ্বিন', 'কার্তিক', 'অগ্রহায়ণ', 'পৌষ',
            'মাঘ', 'ফাল্গুন', 'চৈত্র'
        ];
        const gregorianDate = new Date();
        const monthDays = [31, 31, 31, 31, 30, 30, 30, 30, 30, 29, 29, 30];
        const startOfBanglaYear = new Date(gregorianDate.getFullYear(), 3, 14);
        let banglaYear = gregorianDate.getFullYear() - 593;
        let monthIndex = 0;
        let banglaDay = gregorianDate.getDate();
        if (gregorianDate < startOfBanglaYear) {
            banglaYear -= 1;
            monthIndex = 11;
        } else {
            let daysPassed = Math.floor((gregorianDate - startOfBanglaYear) / (1000 * 60 * 60 * 24));
            for (let i = 0; i < 12; i++) {
                if (daysPassed < monthDays[i]) {
                    monthIndex = i;
                    banglaDay = daysPassed + 1;
                    break;
                }
                daysPassed -= monthDays[i];
            }
        }
        document.querySelectorAll('.bengali-calender').forEach(function(element) {
            element.innerHTML =
                `${convertToBengaliNumber(banglaDay)} ${banglaMonths[monthIndex]} ${convertToBengaliNumber(banglaYear)}`;
        });

    }

    function arabicDate() {
        moment.locale('en');
        let bnMonth = ['মহররম', 'সফর', 'রবিউল আউয়াল', 'রবিউস সানি', 'জমাদিউল আউয়াল', 'জমাদিউস সানি', 'রজব', 'শা’বান',
            'রমজান', 'শাওয়াল', 'জ্বিলকদ', 'জ্বিলহজ'
        ];
        let hijriDate = moment().format('iYYYY-iMM-iDD');
        let splittedDate = hijriDate.split('-');
        let y = convertToBengaliNumber(splittedDate[0]);
        let m = parseInt(splittedDate[1]);
        let d = convertToBengaliNumber(splittedDate[2]);
        let nd = d + ' ' + bnMonth[m] + ' ' + y;
        document.querySelectorAll('.arabic-date').forEach(function(element) {
            element.innerHTML = nd;
        });
    }

    function greogorianCalendar() {
        $banglaWeekDays = ['রবিবার', 'সোমবার', 'মঙ্গলবার', 'বুধবার', 'বৃহস্পতিবার', 'শুক্রবার', 'শনিবার'];
        let bnMonth = ["জানুয়ারি", "ফেব্রুয়ারি", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগস্ট", "সেপ্টেম্বর",
            "অক্টোবর", "নভেম্বর", "ডিসেম্বর"
        ];
        let date = new Date();
        let y = convertToBengaliNumber(date.getFullYear());
        let m = parseInt(date.getMonth());
        let d = convertToBengaliNumber(date.getDate());
        let nd = d + ' ' + bnMonth[m] + ' ' + y;
        document.querySelectorAll('.gregorian-calendar').forEach(function(element) {
            element.innerHTML = $banglaWeekDays[date.getDay()] + ', ' + nd;
        });
    }
    greogorianCalendar();
    arabicDate();
    getBangladeshiBengaliDate();
</script>
<!-- Date Conversion Script End-->


<script type="text/javascript">
    $(window).on('load', function() {
        $('#myModal').modal('show');
    });
</script>

<script type="text/javascript">
    // Carousel Item Cloning
    $('.carousel[data-type="multi"] .item').each(function() {
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));

        for (var i = 0; i < 1; i++) {
            next = next.next();
            if (!next.length) {
                next = $(this).siblings(':first');
            }
            next.children(':first-child').clone().appendTo($(this));
        }
    });

    // Search Toggle
    $(function() {
        var $searchlink = $('.searchtoggl i');
        var $searchbar = $('.searchbar');

        $('a.searchtoggl').on('click', function(e) {
            e.preventDefault();

            if ($(this).attr('class') === 'searchtoggl') {
                if (!$searchbar.is(":visible")) {
                    // Switch the icon to appear collapsible
                    $searchlink.removeClass('fa-search').addClass('fa-search-minus');
                } else {
                    // Switch the icon to appear as a toggle
                    $searchlink.removeClass('fa-search-minus').addClass('fa-search');
                }

                $searchbar.slideToggle(300, function() {
                    // Callback after search bar animation
                });
            }
        });

        $('#searchform').submit(function(e) {
            e.preventDefault(); // Stop form submission
        });
    });

    // Responsive Embeds
    $('.detail-content iframe').wrap('<div class="embed-responsive embed-responsive-16by9" />');
    $('.detail-content iframe').addClass('embed-responsive-item');

    // Responsive Images
    $('.detail-content img').addClass('img-responsive');
    $('figure.image img').addClass('img-responsive');
</script>




<script>
    (function($) {
        var $pswp = $('.pswp')[0];
        var image = [];
        $('.picture').each(function() {
            var $pic = $(this);
            var getItems = function() {
                var items = [];
                $pic.find('a').each(function() {
                    var $href = $(this).attr('href');
                    var $size = $(this).data('size').split('x');
                    var $width = $size[0];
                    var $height = $size[1];
                    var $title = $(this).attr('data-caption');

                    var item = {
                        src: $href,
                        w: $width,
                        h: $height,
                        title: $title
                    };
                    items.push(item);
                });
                return items;
            };

            var items = getItems();

            $.each(items, function(index, value) {
                image[index] = new Image();
                image[index].src = value['src'];
            });
            $pic.on('click', 'figure', function(event) {
                event.preventDefault();

                var $index = $(this).index();
                var options = {
                    index: $index,
                    bgOpacity: 0.7,
                    showHideOpacity: true
                };
                var lightBox = new PhotoSwipe($pswp, PhotoSwipeUI_Default, items, options);
                lightBox.init();
            });
        });
    })(jQuery);
</script>



<script>
    $(document).ready(function() {
        // Affix the navigation
        $('#nav').affix({
            offset: {
                top: $('.header-top-section').height()
            }
        });

        // Initialize Owl Carousel
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 3,
                    nav: false
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: false,
                    margin: 20
                }
            }
        });

        // Custom navigation icons for Owl Carousel
        $('.owl-next').html('<i class="fa fa-angle-right" aria-hidden="true"></i>');
        $('.owl-prev').html('<i class="fa fa-angle-left" aria-hidden="true"></i>');

        // Hover effect for video and photo galleries
        $(".video-gallery-section .image_wrapper, .photo-gallery-album-section .image_wrapper").hover(
            function() {
                $(this).children().css("color", "yellow");
            },
            function() {
                $(this).children().css("color", "rgba(236,26,46,.8)");
            }
        );

        // AJAX call for gallery
        $('body').on('click', '.gallery-ajax', function(e) {
            e.preventDefault();
            var gallery_type = $(this).attr('height');
            var gallery_cat = $(this).attr('width');

            $.ajax({
                url: "site_url('welcome/home_gallery'); ?>",
                method: "post",
                data: {
                    gallery_type: gallery_type,
                    gallery_cat: gallery_cat
                },
                datatype: "html",
                success: function(result) {
                    $('.gallery-text').html(result);
                }
            });
        });

        // Gallery hover effects
        $(".gallery").mouseout(function() {
            $('.gallery .title-cat').slideDown();
        });
        $(".gallery").mouseleave(function() {
            $('.gallery .title-cat').slideUp();
        });


        // AJAX call for weather
        $.ajax({
            url: '{{ route('weathers.index') }}',
            method: "get",
            datatype: "json",
            success: function(res) {
                let result = ``;
                const bengaliNumbers = {
                    '0': '০',
                    '1': '১',
                    '2': '২',
                    '3': '৩',
                    '4': '৪',
                    '5': '৫',
                    '6': '৬',
                    '7': '৭',
                    '8': '৮',
                    '9': '৯',
                    '.': '.'
                };
                if (res.main.temp) {
                    let src = `http://openweathermap.org/img/w/${res.weather[0].icon}.png`;
                    result +=
                        `<img  alt="weather" height="23" src="${src}">${convertToBengaliNumber(res.main.temp)}<sup>o</sup> সে. আদ্রতা ${convertToBengaliNumber(res.main.humidity)}%`;
                }
                $('.weather').html(result);
            }
        });

        // Hover effect for hover-effect class
        $('.hover-effect').mouseover(function() {
            $(this).children().find(".image_wrapper").css("border", "5px solid #CFD3D4");
            $(this).children().next().find("a").css("color", "#FF4A58");
        }).mouseout(function() {
            $(this).children().find(".image_wrapper").css("border", "none");
            $(this).children().next().find("a").css("color", "#000000");
        });
    });
</script>

<script>
    $(document).ready(function() {
        /*==================================
            List view clickable || CATEGORY 
            ==================================*/

        var searchDisplayMode = 'list';

        if (searchDisplayMode) {
            if (searchDisplayMode === 'list') {
                listView('.list-view');
            } else if (searchDisplayMode === 'compact') {
                compactView('.compact-view');
            }
        }

        // List view and compact view toggles
        $('.list-view, #ajaxTabs li a').click(function(e) {
            e.preventDefault();
            listView('.list-view');
            createCookie('searchDisplayModeCookie', 'list', 7);
        });

        $('.compact-view').click(function(e) {
            e.preventDefault();
            compactView(this);
            createCookie('searchDisplayModeCookie', 'compact', 7);
        });
    });

    // List view function
    function listView(selector) {
        $('.grid-view, .compact-view').removeClass("active");
        $(selector).addClass("active");
        $('.item-list').addClass("make-list")
            .removeClass("make-grid make-compact");
        $('.item-list .add-desc-box').removeClass("col-sm-9")
            .addClass("col-sm-7");
    }

    // Compact view function
    function compactView(selector) {
        $('.list-view, .grid-view').removeClass("active");
        $(selector).addClass("active");
        $('.item-list').addClass("make-compact")
            .removeClass("make-list make-grid");
        $('.item-list .add-desc-box').toggleClass("col-sm-9 col-sm-7");
    }

    // JS Cookie functions
    function createCookie(name, value, days) {
        var expires;

        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        } else {
            expires = "";
        }
        document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
    }

    function readCookie(name) {
        var nameEQ = encodeURIComponent(name) + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i].trim();
            if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length));
        }
        return null;
    }

    function eraseCookie(name) {
        createCookie(name, "", -1);
    }
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-115325801-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-115325801-1');
</script>
<script>
    $(".onlinepoll").click(function(e) {
        e.preventDefault();
        let data = {};
        data.value_id = $('input[name=OnlinePoll]:radio:checked').val();
        data.poll_id = $('#poll_id').val();
        data._token = "{{ csrf_token() }}";
        if (data.value_id == '' || data.value_id == null) {
            alert('Please select your option.');
        } else {
            $(".pollbutton").fadeIn(200).after(`<img style="float:left;" class="pollloader" src="{{ asset("public/frontend-assets") }}/images/ajax_loader_bar.gif" />`);
            $(".onlinepoll").fadeOut();
            $.ajax({
                type: 'POST',
                url: '{{ route("online-polls.vote") }}',
                data: data,
                dataType: 'JSON',
                success: function(res) {
                    $(".pollbutton").fadeIn(200).after(`<p style="color:red;">${res.result}</p>`);
                    $(".pollloader").hide();
                }
            });
        }
    });
</script>
