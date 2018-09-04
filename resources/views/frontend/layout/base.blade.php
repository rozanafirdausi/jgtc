<!doctype html>
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" ng-app="jgtc-2018"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="description" content="{{ $description or settings('site-description') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta property="og:url" content="{{ Request::url() }}">
    <meta property="og:title" content="{{ $title or settings('site-name') }}">
    <meta property="og:site_name" content="{{ settings('site-name') }}">
    <meta property="og:description" content="{{ $description or settings('site-description') }}">
    <meta property="og:image" content="{{ $socialImage or asset(settings('site-image')) }}">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="374">
    <meta property="og:image:height" content="121">
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="fb:app_id" content="{{ settings('facebook_client_id') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ Request::url() }}">
    <meta name="twitter:description" content="{{ $description or settings('site-description') }}">
    <meta name="twitter:title" content="{{ $title or settings('site-name') }}">
    <meta name="twitter:image" content="{{ $socialImage or asset(settings('site-image')) }}">

    <link href="{{ asset('backend/css/font-awesome.css') }}" rel="stylesheet"><!-- Font-awesome-CSS --> 
    <link href="{{ asset('backend/css/style.css') }}" rel='stylesheet' type='text/css'/><!-- style.css --> 
    <link href="//fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="apple-touch-icon" href="">
    <link rel="icon" type="image/png" href="{{ settings('logo_url') }}">

    <title>{{ $title or settings('site-name') }}</title>

    <link rel="stylesheet" href="">
    @yield('page-style')

</head>
<body>
    <h1>Login JGTC 2018</h1>
    <div class="main-agile">
        <div class="content-wthree">
        <div class="circle-w3layouts"></div>
            <!--[if lt IE 8]>
                <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
            <![endif]-->

            @include('frontend.partials.flash-notification')

            @yield('notif')

            @yield('before-content')

            @yield('content')

            @yield('js-script')
        </div>
    </div>
</body>
</html>
