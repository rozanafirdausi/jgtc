<section class="section-info" id="information">
    <figure class="section-deco bg-people-info">
        <img src="{{ asset('frontend/assets/img/people-finding-bg-small.png') }}" alt="" class="item-heavy" data-original="{{ asset('frontend/assets/img/people-finding-bg.png') }}">
    </figure>
    <div class="section-content item-heavy" id="lineup" data-original="{{ asset('frontend/assets/img/darksky-bg.png') }}" style="background-image: ;">
        <figure class="section-deco bg-bass-man">
            <img src="{{ asset('frontend/assets/img/blank.png') }}" alt="" class="item-heavy" data-original="{{ asset('frontend/assets/img/bass-man.png') }}">
        </figure>
        <div class="container">
            <div class="section-head text-center">
                <h2 class="h1 font-secondary text-caps text-white">Find The Answer</h2>
            </div>
            <div class="mb-64">
                <h3 class="text-yellowwhite text-caps text-center">
                    Frequently Asked Questions
                </h3>
                <div class="accordeon">
                    @foreach($faqs as $faq)
                    <div class="accordeon__item">
                        <button class="btn btn-accordeon rounded" type="button">
                            <span class="btn-text">
                                {{ $faq->question }}
                            </span>
                            <span class="btn-icon fa fa-angle-down" aria-hidden="true"></span>
                        </button>
                        <div class="accordeon-content">
                            <p>
                                {!! htmlspecialchars_decode($faq->answer) !!}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="mb-64" id="venue">
                <h3 class="text-yellowwhite text-caps text-center">
                    JGTC 2018 SITEPLAN
                </h3>
                <div class="text-center">
                    @if(count($siteplan1)>0 && count($siteplan2)>0)
                    <div class="tab-container">
                        <nav class="block tab-nav">
                            <ul class="list-nostyle">
                                <li class="tab-nav__item is-active">
                                    <a href="#map1">
                                        Site Plan 1
                                    </a>
                                </li>
                                <li class="tab-nav__item">
                                    <a href="#map2">
                                        Site Plan 2
                                    </a>
                                </li>
                            </ul>
                        </nav>
                        <div class="tab-panel">
                            <div class="tab-panel__item is-active" id="map1">
                                <img src="{{ asset('frontend/assets/img/blank.png') }}" data-original="{{ $siteplan1 }}" alt="site plan 1" class="item-heavy">
                            </div>
                            <div class="tab-panel__item" id="map2">
                                <img src="{{ asset('frontend/assets/img/blank.png') }}" data-original="{{ $siteplan2 }}" alt="site plan 2" class="item-heavy">
                            </div>
                        </div>
                    </div>
                    @else
                    <img src="{{ asset('frontend/assets/img/blank.png') }}" alt="" class="item-heavy" data-original="{{ asset('frontend/assets/img/site-plan-soon.png') }}">
                    @endif
                </div>
            </div>
            <div class="mb-16">
                <h3 class="text-yellowwhite text-caps text-center">
                    Find The Way
                </h3>
                <div class="bzg bzg--big-gap separator--m text-white">
                    <div class="bzg_c" data-col="m6">
                        <h3 class="block flex">
                            <img src="{{ asset('frontend/assets/img/icon-train.png') }}" alt="" class="fs-0 mr-16" width="52" height="52">
                            <span class="text-yellowdeep">USING JAKARTA COMMUTER LINE TRAIN</span>
                        </h3>
                        <p>
                            {{ $trainRoute }}
                        </p>
                    </div>
                    <div class="bzg_c" data-col="m6">
                        <h3 class="block flex">
                            <img src="{{ asset('frontend/assets/img/icon-bus.png') }}" alt="" class="fs-0 mr-16" width="52" height="52">
                            <span class="text-yellowdeep">USING TRANSJAKARTA BUS</span>
                        </h3>
                        <p>
                            {{ $busRoute }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>