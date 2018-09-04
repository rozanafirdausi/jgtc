<section class="section-ticket section-sky vit-screen item-heavy" data-original="{{ asset('frontend/assets/img/sky-bg.png') }}" id="ticket" style="background-image:;">
    <figure class="sky-bg">
        <img class="item-heavy" src="{{ asset('frontend/assets/img/blank.png') }}" data-original="{{ asset('frontend/assets/img/fly-bg.png') }}" alt=".">
    </figure>
    <figure class="sky-bird">
        <img class="item-heavy" src="{{ asset('frontend/assets/img/blank.png') }}" data-original="{{ asset('frontend/assets/img/sky-bird.png') }}" alt=".">
    </figure>
    <div class="container">
        <div class="mb-36 text-center">
            <h3 class="no-space font-normal text-maroon text-caps">Go Get it Now!</h3>
            <h2 class="h1 font-secondary text-grey text-caps">Buy Ticket Online</h2>
        </div>
        <div class="bzg h-center">
            @foreach ($tickets as $ticket)
            @if($ticket->status === 'inactive')
            <div class="bzg_c" data-col="m4">
                <div class="tickets pt-32 ticket--sold text-center">
                    <a href="{{ $ticket->url }}" class="is-block text-caps" target="_blank">
                        <img src="{{ asset('frontend/assets/img/ticket-sold.png') }}" width="56" alt="" class="circle ticket-icon">
                        <div class="pl-32 pr-32 ticket-content">
                            <h3 class="mb-16 text-black">
                                {{ $ticket->title }}
                            </h3>
                            <hr class="mb-16 line-2 line-dot">
                            <em class="text-lightgrey"><small>Start From</small></em>
                            <h4 class="mb-16 h1 ticket-price">
                                <sup class="font-lite font-smallest text-grey">IDR</sup>
                                <span class="font-extrabold text-maroon">{{ $ticket->text }}</span>
                            </h4>
                        </div>
                        <span class="is-block p-8 bg-lightgrey text-white label-action">
                            <strong>Buy Ticket</strong>
                        </span>
                    </a>
                        <span class="label-sold text-caps">Sold Out</span>
                </div>
            </div>
            @else
            <div class="bzg_c" data-col="m4">
                <div class="tickets pt-32 text-center">
                    <a href="{{ $ticket->url }}" class="is-block text-caps" target="_blank">
                        <img src="{{ asset('frontend/assets/img/ticket.png') }}" width="56" alt="" class="circle ticket-icon">
                        <div class="pl-32 pr-32 ticket-content">
                            <h3 class="mb-16 text-black">
                                {{ $ticket->title }}
                            </h3>
                            <hr class="mb-16 line-2 line-dot">
                            <em class="text-lightgrey"><small>Start From</small></em>
                            <h4 class="mb-16 h1 ticket-price">
                                <sup class="font-lite font-smallest text-grey">IDR</sup>
                                <span class="font-extrabold text-maroon">{{ $ticket->text }}</span>
                            </h4>
                        </div>
                        <span class="is-block p-8 bg-lightgrey text-white label-action">
                        <strong>Buy Ticket</strong>
                    </span>
                    </a>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
    <figure class="sky-bottom">
        <img class="item-heavy" src="{{ asset('frontend/assets/img/blank.png') }}" data-original="{{ asset('frontend/assets/img/bg-sky-bottom.png') }}" alt=".">
    </figure>
</section>