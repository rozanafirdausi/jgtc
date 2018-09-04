@extends('frontend.layout.base_frontend')

@section('body-content')
    <!--[if lte IE 9]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <div class="sticky-footer-container home-container">
        <div class="sticky-footer-container-item">
            @include('frontend.partials.header')
        </div>
        <div class="sticky-footer-container-item --pushed">
            <main class="site-main">
                @include('frontend.partials.home-hero')

                <section class="section-countdown">
                    <div class="container"></div>
                </section>

                @include('frontend.partials.ticket')
                @include('frontend.partials.line-up')
                @include('frontend.partials.information')
                @include('frontend.partials.schedule')
                @include('frontend.partials.playlist')
                @include('frontend.partials.merchandise')
                @include('frontend.partials.story')
                @include('frontend.partials.history')
                @include('frontend.partials.partner')
            </main>
        </div>
        <div class="sticky-footer-container-item">
            @include('frontend.layout.footer')
        </div>
    </div>

    @include('frontend.partials.scripts')

@endsection