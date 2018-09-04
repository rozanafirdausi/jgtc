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
                <div class="page-head">
                    <div class="container">
                        <div class="page-head__title text-center text-caps">
                            <h3 class="mb-0 font-normal text-maroon">For Sell</h3>
                            <h1 class="text-caps font-secondary main-title">
                                <span>Merchandise</span>
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="mb-24 bzg">
                        @foreach ($merchandises as $merchandise)
                        <div class="block bzg_c text-center" data-col="m3">
                            <h4 class="mb-0"><a href="{{ $merchandise->url }}" class="link-black text-ellipsis" target="_blank">
                                {{ $merchandise->title }}
                            </a></h4>
                            <p class="mb-0 text-grey">{{ $merchandise->text }}</p>
                            <a href="{{ $merchandise->url }}" class="btn btn--block btn--iconic link-maroon" title="Add to Cart" target="_blank">
                                <span class="fas fa-shopping-cart" aria-hidden="true"></span>
                            </a>
                            <figure>
                                <a href="{{ $merchandise->url }}" target="_blank">
                                    <img src="{{ $merchandise->filename_merch }}" alt="{{ $merchandise->title }}">
                                </a>
                            </figure>
                        </div>
                        @endforeach
                    </div>
                </div>
            </main>
        </div>
        <div class="sticky-footer-container-item">
                @include('frontend.layout.footer')
        </div>
    </div>

    @include('frontend.partials.scripts')
@endsection
