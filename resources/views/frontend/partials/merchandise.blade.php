<section class="section-merchandise" id="merchandise">
	<div class="section-content text-center">
		<div class="container">
			<h3 class="no-space font-normal text-maroon text-caps">For Sale</h3>
			<h2 class="h1 font-secondary text-grey text-white">Merchandise</h2>
			@if(count($merchandises)>0)
			<div class="mb-48 bzg">
				@foreach ($merchandises as $merchandise)
				<div class="block bzg_c text-center" data-col="m3">
					<h4 class="mb-0">
						<a href="{{ $merchandise->url }}" class="link-black text-ellipsis" target="_blank">
						{{ $merchandise->title }}
						</a>
					</h4>
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
			<div class="text-center">
				<a href="{{ route('frontend.merchandise') }}" class="btn btn--ghost-maroon rounded">View All <span class="fa fa-angle-right"></span></a>
			</div>
			@else
			<div class="text-center">
				<img src="{{ asset('frontend/assets/img/blank.png') }}" alt="" data-original="{{ asset('frontend/assets/img/merchandise-soon.png') }}" class="item-heavy">
			</div>
			@endif
		</div>
	</div>
</section>