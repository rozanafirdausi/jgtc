<footer class="site-footer">
	<div class="container footer-top">
		<figure class="footer-logo">
			<a href="../home/home.blade.php">
				<img src="{{ asset('frontend/assets/img/Logo-JGTC-white.png') }}" alt="JGTC">
			</a>
		</figure>
		<div class="block footer-info">
			<p>
				{!! nl2br(e(htmlspecialchars_decode($footer))) !!}
			</p>
			<div class="">
				<a href="tel:{{ settings('official-phone', '') }}" class="in-block">
					{!! settings('official-phone') ? '<strong>T:</strong> ' . settings('official-phone') : '' !!}
				</a>
				<a href="mailto:{{ settings('official-email', '') }}" class="in-block">
					{!! settings('official-email') ? '<strong>E:</strong> ' . settings('official-email') : '' !!}
				</a>
			</div>
		</div>
		<div class="footer-connect">
			<div class="block">
				<h3 class="mb-8 font-normal text-caps">
					Official Mobile Apps
				</h3>
				<div class="download-apps">
					<a href="{{ settings('official-app-store', '') }}" class="in-block btn-download-app" target="_blank">
						<img src="{{ asset('frontend/assets/img/download-appstore.png') }}" alt="">
					</a>
					<a href="{{ settings('official-play-store', '') }}" class="in-block btn-download-app" target="_blank">
						<img src="{{ asset('frontend/assets/img/download-googleplay.png') }}" alt="">
					</a>
				</div>
			</div>
			<ul class="list-nostyle social-nav">
    			<li class="social-nav__item">
    				<a href="{{ settings('official-facebook', '') }}" aria-label="Facebook" target="_blank">
    					<span class="fab fa-facebook" aria-hidden="true"></span>
    				</a>
    			</li>
    			<li class="social-nav__item">
    				<a href="{{ settings('official-twitter', '') }}" aria-label="Twitter" target="_blank">
    					<span class="fab fa-twitter" aria-hidden="true"></span>
    				</a>
    			</li>
    			<li class="social-nav__item">
    				<a href="{{ settings('official-instagram', '') }}" aria-label="Instagram" target="_blank">
    					<span class="fab fa-instagram" aria-hidden="true"></span>
    				</a>
    			</li>
    		</ul>
		</div>
	</div>
	<div class="copyrights">
		<div class="container">
			Copyrights &COPY; 2018 Jazz Goes To Campus
		</div>
	</div>
</footer>