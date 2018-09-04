<section class="section-playlist item-heavy" id="playlist" data-original="{{ asset('frontend/assets/img/bg-playlist.png') }}" style="background-image: ;">
	<div class="section-content text-center">
		<div class="container">
			<h3 class="no-space font-normal text-white text-caps">Listening to</h3>
			<h2 class="h1 font-secondary text-caps text-white">JGTC Playlist</h2>
			<div class="playlist">
				<div class="playlist__cover">
					<div class="media-responsive r--square">
						<img src="{{ asset('frontend/assets/img/blank.png') }}" alt="Playlist" class="item-heavy" data-original="{{ asset('frontend/assets/img/bg-playlist-cover.jpg') }}">
					</div>
				</div>
				<div class="playlist__widget">
					<div class="media-embed">
						<iframe src="{{ $spotifyPlaylistUrl }}" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>