<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="description" content="{{ $description or settings('site-description') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="theme-color" content="#f8f2d5">
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

    <link rel="apple-touch-icon" href="{{ asset('frontend/assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ settings('logo_url') }}">

    <title>{{ $title or settings('site-name') }}</title>

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css') }}">

    {!! settings('ga_script', '') !!}

</head>
<body>
    @yield('body-content')
</body>
</html>