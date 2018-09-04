<section class="section-story item-heavy" id="lineup" data-original="{{ asset('frontend/assets/img/darkersky-bg.png') }}" style="background-image: ;">
	<figure class="section-deco bg-wave">
		<img src="{{ asset('frontend/assets/img/bg-wave-white.png') }}" alt="">
	</figure>
	<figure class="section-deco bg-balloon">
		<img src="{{ asset('frontend/assets/img/blank.png') }}" alt="" class="item-heavy" data-original="{{ asset('frontend/assets/img/bg-baloon.png') }}">
	</figure>
	<div class="section-content">
		<div class="container">
				<h2 class="h1 mb-16 font-secondary text-caps text-white text-center">Here's Our Story</h2>

			<div class="bzg bzg--big-gap v-center">
				<div class="mb-48 bzg_c" data-col="m6">
					<div class="text-yellowdeep text-caps">Profile</div>
					<h3 class="h2 mb-0 text-yellowwhite text-caps">
						Jazz Goes to Campus
					</h3>
					<div class="flex text-white">
						<span class="nowrap h1 space-minus text-line-small">---</span>
						<div class="pl-16 fg-1">
							{{ $profile }}
						</div>
					</div>
				</div>
				<div class="bzg_c text-center" data-col="m6">
					<img src="{{ asset('frontend/assets/img/bg-saxophone-man.png') }}" alt="">
				</div>
			</div>
		</div>
	</div>
	<figure class="section-deco bg-wave bg-wave--bottom">
		<img src="{{ asset('frontend/assets/img/bg-wave-white.png') }}" alt="">
	</figure>
</section>