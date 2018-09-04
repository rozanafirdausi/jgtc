@extends('frontend.layout.base_frontend')

@section('body-content')
    <!--[if lte IE 9]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <div class="sticky-footer-container">
        <div class="sticky-footer-container-item">
            @include('frontend.partials.header-detail')
        </div>
        <div class="sticky-footer-container-item --pushed main--page">
            <main class="site-main">
                <section class="section-block">
                    <div class="container">
                        <div class="bzg">
                            @foreach ($performers as $performer)
                            <div class="mb-24 bzg_c" data-col="m4, l5">
                                <figure class="">
                                    <img src="{{ $performer->avatar_medium_avatar }}" alt="{{ $performer->name }}">
                                </figure>
                            </div>
                            <div class="bzg_c" data-col="m8, l7">
                                <div class="mb-24">
                                    <h1 class="mb-0 text-caps text-maroon">{{ $performer->name }}</h1>
                                    <div class="flex v-center">
                                        <span class="fg-1 text-caps">{{ $performer->type }}</span>
                                        <ul class="list-nostyle social-nav flex">
                                            <!-- <li class="social-nav__item">
                                                <a href="#" class="btn btn--iconic" aria-label="Facebook">
                                                    <span class="fab fa-facebook" aria-hidden="true"></span>
                                                </a>
                                            </li>
                                            <li class="social-nav__item">
                                                <a href="#" class="btn btn--iconic" aria-label="Twitter">
                                                    <span class="fab fa-twitter" aria-hidden="true"></span>
                                                </a>
                                            </li>
                                            <li class="social-nav__item">
                                                <a href="#" class="btn btn--iconic" aria-label="Instagram">
                                                    <span class="fab fa-instagram" aria-hidden="true"></span>
                                                </a>
                                            </li>
                                            <li class="social-nav__item">
                                                <a href="#" class="btn btn--iconic" aria-label="Google Plus">
                                                    <span class="fab fa-google-plus-g" aria-hidden="true"></span>
                                                </a>
                                            </li>
                                            <li class="social-nav__item">
                                                <a href="#" class="btn btn--iconic" aria-label="Spotify">
                                                    <span class="fab fa-spotify" aria-hidden="true"></span>
                                                </a>
                                            </li> -->
                                        </ul>
                                    </div>
                                </div>
                                <p>
                                    {!! nl2br($performer->description) !!}
                                </p>
                                <div class="mb-24">
                                    <div class="mb-16 flex v-center">
                                        <h3 class="mb-0 fg-1 font-lite text-caps">Video</h3>
                                        <div class="text-right" id="videoSlideDots"></div>
                                    </div>
                                    <div class="video-artist-slider colorbox">
                                        @foreach ($performer->galleries as $gallery)
                                        @if($gallery->type === 'video')
                                        <figure class="mb-0 mr-16 slider__item">
                                            <a href="{{ $gallery->url }}" class="video-colorbox responsive-media r-16-9 media-play play--small rounded">
                                                <img src="{{ $gallery->content_small_video }}" alt="">
                                            </a>
                                        </figure>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                                <!-- VIDEO -->
                                <div class="mb-24">
                                    <div class="mb-16 flex v-center">
                                        <h3 class="mb-0 fg-1 font-lite text-caps">Photo</h3>
                                        <div class="text-right" id="photoSlideDots"></div>
                                    </div>
                                    <div class="photo-artist-slider colorbox">
                                        @foreach ($performer->galleries as $gallery)
                                        @if($gallery->type === 'image')
                                        <figure class="mb-0 mr-16 slider__item">
                                            <a href="{{ $gallery->content_medium_image }}" class="photo-colorbox responsive-media r-1 rounded">
                                                <img src="{{ $gallery->content_small_image }}" alt="gallery">
                                            </a>
                                        </figure>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                                <!-- Photo -->
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            </main>
        </div>
        <div class="sticky-footer-container-item">
            @include('frontend.layout.footer')
        </div>
    </div>

    @include('frontend.partials.scripts')
@endsection
