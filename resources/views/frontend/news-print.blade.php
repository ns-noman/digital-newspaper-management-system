@php
    $basicInfo = Cache::remember('basic_info', 60, function () {
        return \App\Models\BasicInfo::first();
    });
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $data['newsdata']->NewsTitle; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta charset="utf-8">
    <meta name="viewport"
    content="width=device-width, minimum-scale=1, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/uploads/basic-info/' . $basicInfo->FavIcon) }}">

    <link rel="stylesheet" href="">
    <link href="" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <style type="text/css">
        .publish-content figure {
            width: 100% !important
        }

        .publish-content figure figcaption {
            font-size: 16px !important;
            font-style: italic !important;
            background-color: #f1f1f1;
            border-bottom: 2px solid #dbd6dd;
            padding: 5px;
            width: 100% !important;
            margin-bottom: 20px;
        }

        .publish-content figure figcaption span {
            font-size: 16px !important;
            font-style: italic !important;
        }
    </style>
    <style type="text/css">
        .print-page,
        .print-page p,
        .print-page div,
        .print-page div p,
        .print-page span {
            font-size: 22px !important;
            line-height: 28px !important;
        }

        .image-caption,
        .image-caption span {
            font-size: 18px !important;
        }

        .publish-content img {
            width: 100% !important
        }

        .logo {
            height: 50px;
            margin-bottom: 30px;
        }

        @media screen and (max-width: 768px) {
            .logo {
                height: 30px;
                margin-bottom: 30px;
            }
        }
    </style>
</head>

<body style="background: #F0F0ED;">
    <button style="border-radius: 0px" class="btn btn-primary btn-block print-content"><i class="fa fa-print fa-lg"></i>
        PRINT</button>
    <div class="container">
        <div class="marginT10 xs-marginT0"></div>
        <div class="row">
            <div class="col-md-12 ">
                <div style="background-color: white;padding: 15px">
                    <div style="padding: 0px">
                        <img class="img-responsive-2"src="{{ asset('public/uploads/basic-info/logo2.png') }}" alt="বাংলাদেশের খবর">

                        <br>
                    </div>

                    <div class="marginB30 xs-marginB15">
                        <div style="margin-top: 20px">
                            <p style="margin-bottom: 0px">আপডেট : {{ app('date.formatter2')->toBanglaDigit(date('d F Y', strtotime($data['newsdata']->Date))) }} </p>
                        </div>
                        <h3 class="sub-title">{{ $data['newsdata']->NewsShoulder }}</h3>
                        <h2 class="detailHeadline" style="margin: 0px"> {{ $data['newsdata']->NewsTitle }} </h2>
                        <h3 class="sub-title padding-bottom-10">{{ $data['newsdata']->NewsHanger }}</h3>
                    </div>


                    <div class="newsPhoto">
                        <div>
                            <div style="position: relative;cursor: pointer;">
                                <img src="{{ asset('public/uploads/news/'. $data['newsdata']->Image) }}" alt="" class="img-responsive"
                                    style="width: 100%">
                                <p
                                    style="margin: 0px;padding: 5px;background-color: #f1f1f1;border-bottom: 2px solid #dbd6dd;font-size: 16px;font-style: italic;">

                                    @if($data['newsdata']->CaptionHeading)
                                        <div class="side-1">
                                            <h2>{{ $data['newsdata']->CaptionHeading }} {{ $data['newsdata']->ImageTitle }}</h2>
                                        </div>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="publish-content">
                                <br>
                                <p style="text-align: justify; "><span
                                        style="background-color: initial; font-size: 0.75rem; letter-spacing: 0px;">
                                        {!! $data['task']->Detail !!}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <h3>বাংলাদেশের খবর </h3>
                            <p style="margin:0px;padding:0px">Plot-314/A, Road # 18, Block # E, Bashundhara R/A,
                                Dhaka-1229, Bangladesh.</p>

                            <p style="margin:0px;padding:0px">বার্তাবিভাগঃ newsbnel@gmail.com</p>
                            <p style="margin:0px;padding:0px">
                                অনলাইন বার্তাবিভাগঃ bk.online.bnel@gmail.com </p>
                            <p style="margin:0px;padding:0px">
                                ফোনঃ ৫৭১৬৪৬৮১
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="marginT10 xs-marginT0"></div>
    </div>

    <script type="text/javascript" src="https://en.shampratikdeshkal.com/assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="https://en.shampratikdeshkal.com/assets/bootstrap/js/bootstrap.min.js"></script>
    <script>
        $(".print-content").click(function() {
            $(".print-content").hide();
            window.print($(".text-content"));
            $(".print-content").show();
        });
    </script>
    <script type="text/javascript">
        var s = $("#deatil-con").val();
        s = s.replace(/<a>/g, "<div class='try'>");
        s = s.replace(/<\/a>/g, "</div>");
        $("#deatil-show").html(s);
    </script>
</body>

</html>
