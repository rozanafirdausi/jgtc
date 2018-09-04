<section class="section-schedule" id="pre-event">
	<figure class="section-deco bg-curve-white">
		<img src="{{ asset('frontend/assets/img/bg-curve-white.png') }}" alt=".">
	</figure>
	<figure class="section-deco bg-guitar-man">
		<img class="item-heavy" src="{{ asset('frontend/assets/img/blank.png') }}" data-original="{{ asset('frontend/assets/img/bg-guitar-man.png') }}" alt=".">
	</figure>
	<div class="section-content">
		<div class="container">
			<div class="text-center">
				<h3 class="no-space font-normal text-maroon text-caps">Don't Miss Out</h3>
				<h2 class="text-caps font-semibold text-brightblue">JGTC 2018 Pre-Event Schedule</h2>
			</div>
			<div class="schedule-list fg-1">
				@foreach($preEvents as $schedule)
				<div class="schedule-list__item">
					<div class="date">
						<span class="day">{{ \Carbon\carbon::parse($schedule->start_date)->format('d') }}</span>
						<span class="month">{{ \Carbon\carbon::parse($schedule->start_date)->formatLocalized('%b') }}</span>
					</div>
					<div class="fig">
						<img src="{{ $schedule->image_small_pre_event }}" alt="{{ $schedule->title }}">
					</div>
					<div class="schedule__info">
						<h3 class="h4 title text-caps">
							{{ $schedule->title }}
						</h3>
						<div class="location">
							<span class="icon-location fa fa-map-marker-alt"></span>
							{{ $schedule->location }}
						</div>
						<time class="time">
							<span class="time-icon far fa-clock"></span>
							{{ \Carbon\carbon::parse($schedule->start_date)->format('H:i') }}
						</time>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</section>