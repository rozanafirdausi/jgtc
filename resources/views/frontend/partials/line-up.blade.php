<section class="section-lineup text-center item-heavy" id="lineup" data-original="{{ asset('frontend/assets/img/bg-music.png') }}" style="background-image: ;">
	<figure class="section-deco bg-people-trumpet">
		<img src="{{ asset('frontend/assets/img/blank.png') }}" alt="" class="item-heavy" data-original="{{ asset('frontend/assets/img/bg-people-trumpet.png') }}">
	</figure>
	<div class="section-content">
		<div class="mb-64">
			<h3 class="no-space font-normal text-maroon text-caps">Meet The Artist</h3>
			<h2 class="h1 font-secondary text-caps text-grey">Event Performers</h2>
			<div class="block overflow">
				<div class="block line-up-carousell">
					@foreach($performers as $performer)
					<figure class="no-space carousell__item artist__item ml-8 mr-8">
						<div class="responsive-media r-3-4">
						<a href="{{ route('frontend.lineup', $performer->id) }}" class="fig-img">
							<img src="{{ asset('frontend/assets/img/bg-artist.png') }}" data-lazy="{{ $performer->avatar_medium_banner }}" alt="{{ $performer->name }}">
							<span class="view-detail">
								<span class="btn btn--ghost-white rounded">View Detail</span>
							</span>
						</a>
						<figcaption>
							<h4 class="mb-4 text-caps">
								<a href="#" class="text-ellipsis link-white">{{ $performer->name }}</a>
							</h4>
							<!-- <div class="text-center">
								<a href="#" class="btn--iconic link-white" title="Facebook">
									<span class="fab fa-facebook" aria-hidden="true"></span>
								</a>
								<a href="#" class="btn--iconic link-white" title="Twitter">
									<span class="fab fa-twitter" aria-hidden="true"></span>
								</a>
								<a href="#" class="btn--iconic link-white" title="Instagram">
									<span class="fab fa-instagram" aria-hidden="true"></span>
								</a>
							</div> -->
						</figcaption>
						</div>
					</figure>
					@endforeach
				</div>
			</div>
		</div>

		<div class="container">
			<div class="section-content">
				<h2 class="h1 font-secondary text-caps text-grey" id="schedule">JGTC Rundown</h2>
				@if(count($scheduleOnStages)>0)
				@foreach($scheduleOnStages as $stage_name => $schedules)
				<div class="bzg">
					<div class="block bzg_c" data-col="m6, l3">
						<div class="full-height rounded bg-white shadow p-16 text-center">
							<h3 class="h2 mb-8 text-maroon text-caps">
								{{ $stage_name }}
							</h3>
							<hr class="mb-8 line-2 line-dot">
							<table class="mb-0 text-left text-line-small font-small cell-top">
								<tbody>
									@foreach($schedules as $schedule)
									<tr>
										<td class="pb-8 pr-8 nowrap">{{ \Carbon\carbon::parse($schedule->start_date)->format('H:i') }} &mdash; {{ \Carbon\carbon::parse($schedule->end_date)->format('H:i') }}</td>
										<td class="pb-8">
											<strong>
												{{ $schedule->title }}
											</strong>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				@endforeach
				@else
				<div class="text-center">
					<img src="{{ asset('frontend/assets/img/blank.png') }}" alt="" class="item-heavy" data-original="{{ asset('frontend/assets/img/run-down-soon.png') }}">
				</div>
				@endif
			</div>
			<figure class="section-deco bg-woman-dance-white">
				<img src="{{ asset('frontend/assets/img/blank.png') }}" alt="" class="item-heavy" data-original="{{ asset('frontend/assets/img/bg-woman-dance-white.png') }}">
			</figure>
			<figure class="section-deco bg-woman-dance-yellow">
				<img src="{{ asset('frontend/assets/img/blank.png') }}" alt="" class="item-heavy" data-original="{{ asset('frontend/assets/img/bg-woman-dance-yellow.png') }}">
			</figure>
		</div>
	</div>
	<figure class="section-deco bg-woman-trumpet">
		<img src="{{ asset('frontend/assets/img/blank.png') }}" alt="" class="item-heavy" data-original="{{ asset('frontend/assets/img/bg-woman-trumpet.png') }}">
	</figure>
</section>