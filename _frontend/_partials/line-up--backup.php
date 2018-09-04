<section class="section-lineup text-center" id="lineup">
	<h3 class="no-space font-normal text-maroon text-caps">Meet The Artist</h3>
	<h2 class="h1 font-secondary text-caps">Event Performers</h2>

	<div class="tab-container">
		<nav class="block tab-nav text-caps">
			<ul class="list-nostyle">
				<li class="tab-nav__item is-active">
					<a href="#stageA">Stage A</a>
				</li>
				<li class="tab-nav__item">
					<a href="#stageB">Stage B</a>
				</li>
				<li class="tab-nav__item">
					<a href="#stageC">Stage C</a>
				</li>
				<li class="tab-nav__item">
					<a href="#stageD">Stage D</a>
				</li>
			</ul>
		</nav>
		<div class="tab-panel">
			<div class="tab-panel__item is-active" id="stageA">
				<div class="line-up-carousell first-init">
					<?php for ($i=1; $i <= 20; $i++) { ?>
					<figure class="no-space carousell__item ml-8 mr-8">
						<a href="#" class="fig-img">
							<img src="http://via.placeholder.com/225x300?text=ratioA+3:4" alt="">
							<span class="view-detail">
								<span class="btn btn--ghost-white rounded">View Detail</span>
							</span>
						</a>
						<figcaption>
							<h4 class="mb-4 text-caps">
								<a href="#" class="text-ellipsis link-white">Mary Lou Williams</a>
							</h4>
							<div class="text-center">
								<a href="#" class="btn--iconic link-white" title="Facebook">
									<span class="fab fa-facebook" aria-hidden="true"></span>
								</a>
								<a href="#" class="btn--iconic link-white" title="Twitter">
									<span class="fab fa-twitter" aria-hidden="true"></span>
								</a>
								<a href="#" class="btn--iconic link-white" title="Instagram">
									<span class="fab fa-instagram" aria-hidden="true"></span>
								</a>
							</div>
						</figcaption>
					</figure>
					<?php } ?>
				</div>
			</div>
			<div class="tab-panel__item" id="stageB">
				<div class="line-up-carousell first-init">
					<?php for ($i=1; $i <= 20; $i++) { ?>
					<figure class="no-space carousell__item ml-8 mr-8">
						<a href="#" class="fig-img">
							<img src="http://via.placeholder.com/225x300?text=ratioB+3:4" alt="">
							<span class="view-detail">
								<span class="btn btn--ghost-white rounded">View Detail</span>
							</span>
						</a>
						<figcaption>
							<h4 class="mb-4 text-caps">
								<a href="#" class="text-ellipsis link-white">Mary Lou Williams</a>
							</h4>
							<div class="text-center">
								<a href="#" class="btn--iconic link-white" title="Facebook">
									<span class="fab fa-facebook" aria-hidden="true"></span>
								</a>
								<a href="#" class="btn--iconic link-white" title="Twitter">
									<span class="fab fa-twitter" aria-hidden="true"></span>
								</a>
								<a href="#" class="btn--iconic link-white" title="Instagram">
									<span class="fab fa-instagram" aria-hidden="true"></span>
								</a>
							</div>
						</figcaption>
					</figure>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>