<link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/uploads/basic-info/' . $basicInfo->FavIcon) }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('public/frontend-assets') }}/css/bootstrap.css">
<link rel="stylesheet" href="{{ asset('public/frontend-assets') }}/css/style.css?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('public/frontend-assets') }}/css/style-2.css?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('public/frontend-assets') }}/css/style-responsive.css?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('public/frontend-assets') }}/css/style-responsive-2.css">
<link rel="stylesheet" href="{{ asset('public/frontend-assets') }}/css/docs.theme.min.css">
<!-- Core CSS file -->
<link rel="stylesheet" href="{{ asset('public/frontend-assets') }}/zoom/photoswipe.css">
<link rel="canonical" href="{{ url()->full() }}">
<link rel="stylesheet" href="{{ asset('public/frontend-assets') }}/zoom/default-skin/default-skin.css">
@if (strpos(request()->header('User-Agent'), 'Firefox') !== false)
    <link rel="stylesheet" href="{{ asset('public/frontend-assets/css/firefox.css') }}">
@elseif (strpos(request()->header('User-Agent'), 'Chrome') !== false)
    <link rel="stylesheet" href="{{ asset('public/frontend-assets/css/chrome.css') }}">
@endif
<style>
    .shoulder {
        margin-bottom: 0px;
        font-size: 16px
    }
    .hanger {
        font-size: 16px
    }
    ul.update-comment {
        margin-bottom: 5px;
    }
    .detail-content a {
        color: red;
        font-weight: bold;
    }
    ul.nav li.dropdown:hover ul.dropdown-menu,
    ul.nav li.dropdown:hover div.dropdown-menu {
        display: block;
    }
    #nav.affix {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 10;
        border-bottom: 1px solid #B9B9B9;
        box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);
    }
    .navbar-brand {
        padding-left: 15px;

    }
    @media only screen and (max-width: 767px) {
        .m-margin {
            margin-left: 15px;
        }
    }
</style>
