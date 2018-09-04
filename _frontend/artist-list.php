<!doctype html>
<html class="no-js" lang="en">
<?php include '_partials/head.php'; ?>
<body>
    <!--[if lte IE 9]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <div class="sticky-footer-container">
        <div class="sticky-footer-container-item">
            <?php include '_partials/header.php'; ?>
        </div>
        <div class="sticky-footer-container-item --pushed main--page">
            <main class="site-main">
                <div class="page-head">
                    <div class="container">
                        <div class="page-head__title text-center text-caps">
                            <h3 class="mb-0 font-normal text-maroon">Meet Artist</h3>
                            <h1 class="text-caps font-secondary main-title">
                                <span>Event Performers</span>
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="tab-container" data-first-tab="international_artist">
                        <nav class="block tab-nav">
                            <ul class="list-nostyle">
                                <li class="tab-nav__item">
                                    <a href="#international_artist" data-filter="international_artist">International</a>
                                </li>
                                <li class="tab-nav__item">
                                    <a href="#national_artist" data-filter="national_artist">National</a>
                                </li>
                            </ul>
                        </nav>
                        <div class="tab-panel">
                            <div class="bzg">
                                <?php for ($i=1; $i <= 15; $i++) { ?>
                                <div class="block bzg_c" data-col="m4, l3" data-filterlist="international_artist" style="display: none;">
                                    <figure class="no-space artist__item">
                                        <div class="responsive-media r-3-4">
                                        <a href="#" class="fig-img">
                                            <img src="assets/img/bg-artist.png" class="item-heavy" 
                                            data-original="http://via.placeholder.com/225x300?text=International" alt="">
                                            <span class="view-detail">
                                                <span class="btn btn--ghost-white rounded">View Detail</span>
                                            </span>
                                        </a>
                                        <figcaption>
                                            <h4 class="mb-4 text-caps text-center">
                                                <a href="#" class="text-ellipsis link-white" title="Mary Lou Williams">Mary Lou Williams</a>
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
                                        </div>
                                    </figure>
                                </div>
                                <?php } ?><?php for ($i=1; $i <= 15; $i++) { ?>
                                <div class="block bzg_c" data-col="m4, l3" data-filterlist="national_artist" style="display: none;">
                                    <figure class="no-space artist__item">
                                        <div class="responsive-media r-3-4">
                                        <a href="#" class="fig-img">
                                            <img src="assets/img/bg-artist.png" class="item-heavy" 
                                            data-original="http://via.placeholder.com/225x300?text=National" alt="">
                                            <span class="view-detail">
                                                <span class="btn btn--ghost-white rounded">View Detail</span>
                                            </span>
                                        </a>
                                        <figcaption>
                                            <h4 class="mb-4 text-caps text-center">
                                                <a href="#" class="text-ellipsis link-white" title="Sandy Sandoro Lestari">Sandy Sandoro Lestari</a>
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
                                        </div>
                                    </figure>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div class="sticky-footer-container-item">
            <?php include '_partials/footer.php'; ?>
        </div>
    </div>

    <?php include '_partials/scripts.php'; ?>
</body>
</html>
