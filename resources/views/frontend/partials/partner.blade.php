<section class="section-partner" id="partner">
	<div class="section-content">
		<div class="container">
			<!-- <h2 class="mb-48 text-center text-caps text-brightblue">Thanks to Our</h2> -->
			<div class="mb-48">
				<h4 class="text-center text-maroon text-caps">
					Powered By
				</h4>
				@foreach($organizerSponsors as $sponsor)
				<div class="bzg separator--m v-center">
					<div class="block bzg_c text-center" data-col="m6">
						<img src="{{ $sponsor->logo }}" alt="{{ $sponsor->name }}" width="286">
					</div>
					<div class="block bzg_c" data-col="m6">
						{{ $sponsor->description }}
					</div>
				</div>
				@endforeach
			</div>
			@if(count($supporterSponsors) > 0)
			<div class="mb-64">
				<h4 class="text-center text-maroon text-caps">
					Sponsored By
				</h4>
				<div class="sponsor-slider">
					@foreach($supporterSponsors as $sponsor)
					<div class="sponsor__item text-center">
						<a href="{{ $sponsor->url }}" target="_blank">
							<img data-lazy="{{ $sponsor->logo }}" alt="{{ $sponsor->name }}">
						</a>
					</div>
					@endforeach
				</div>
			</div>
			@endif
			@if(count($ticketSponsors) > 0)
			<div class="mb-64">
				<h4 class="text-center text-maroon text-caps">
					Official Ticketing Partner
				</h4>
				<div class="text-center">
					<?php $sponsor = $ticketSponsors->first();?>
					<a href="{{ $sponsor->url }}">
						<img src="{{ $sponsor->logo }}" alt="{{ $sponsor->name }}">
					</a>
				</div>
			</div>
			@endif
			@if(count($mediaSponsors) > 0)
			<div class="mb-64">
				<h4 class="text-center text-maroon text-caps">
					Media Partner
				</h4>
				<div class="sponsor-slider">
					@foreach($mediaSponsors as $sponsor)
					<div class="sponsor__item text-center">
						<a href="{{ $sponsor->url }}" target="_blank">
							<img data-lazy="{{ $sponsor->logo }}" alt="{{ $sponsor->name }}">
						</a>
					</div>
					@endforeach
				</div>
			</div>
			@endif
		</div>
	</div>
	<figure class="section-deco bg-violinist">
		<img src="{{ asset('frontend/assets/img/blank.png') }}" alt="" class="item-heavy" data-original="{{ asset('frontend/assets/img/bg-violinist.png') }}">
	</figure>
	<figure class="section-deco bg-laying-man">
		<img src="{{ asset('frontend/assets/img/blank.png') }}" alt="" class="item-heavy" data-original="{{ asset('frontend/assets/img/bg-laying-man.png') }}">
	</figure>
</section>