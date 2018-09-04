<header class="site-header" data-post="">
    <div class="container">
        <h1 class="sr-only">JGTC 2018</h1>
        <a href="{{ url('/') }}" class="site-logo">
            <img src="{{ $profileImage }}" alt="JGTC">
        </a>
        <h2 class="site-desc">The Oldest &amp; Most Celebrated International Jazz Festival in Indonesia</h2>
        <div class="site-action">
            <a href="{{ url('/') . '#ticket' }}" class="btn btn--black text-up btn-buy">Buy Ticket</a>
        </div>
        <nav class="main-nav">
            <button class="btn-mainnav" type="button">
                <span class="btn-icon btn-icon--open fa fa-bars" aria-hidden="true"></span>
                <span class="btn-icon btn-icon--close fa fa-times" aria-hidden="true"></span>
            </button>
            <div class="toggle-panel">
                <ul class="list-nostyle primary-nav">
                    @foreach($menus as $menu)
                    <li class="primary-nav__item">
                        <a href="{{ url('/') }}/{{ $menu->url }}">{{ $menu->label }}</a>
                    </li>
                    @endforeach
                </ul>
                <!-- <ul class="list-nostyle social-nav">
                    <li class="social-nav__item">
                        <a href="#" aria-label="Facebook">
                            <span class="fab fa-facebook" aria-hidden="true"></span>
                        </a>
                    </li>
                    <li class="social-nav__item">
                        <a href="#" aria-label="Twitter">
                            <span class="fab fa-twitter" aria-hidden="true"></span>
                        </a>
                    </li>
                    <li class="social-nav__item">
                        <a href="#" aria-label="Instagram">
                            <span class="fab fa-instagram" aria-hidden="true"></span>
                        </a>
                    </li>
                    <li class="social-nav__item">
                        <a href="#" aria-label="Google Plus">
                            <span class="fab fa-google-plus-g" aria-hidden="true"></span>
                        </a>
                    </li>
                    <li class="social-nav__item">
                        <a href="#" aria-label="Spotify">
                            <span class="fab fa-spotify" aria-hidden="true"></span>
                        </a>
                    </li>
                </ul> -->
            </div>
        </nav>
    </div>
</header>