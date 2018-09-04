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
                            <h3 class="mb-0 font-normal text-maroon">Showcase</h3>
                            <h1 class="text-caps font-secondary main-title">
                                <span>Gallery JGtC</span>
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="mb-24 bzg">
                        <div class="block bzg_c" data-col="m4, l3">
                            <div class="p-16 filter-box toggle-nav">
                                <div class="filter-box__title">
                                    <h3 class="mb-0 filter-toggle text-caps" data-toggle="filterToggle">Filter</h3>
                                </div>
                                <div class="filter-box__content toggle-panel" id="filterToggle">
                                    <div class="mb-16 toggle-content toggle-nav">
                                        <button class="btn-toggle" type="button" data-toggle="filterMedia">
                                            <span class="btn-text">Media</span>
                                            <span class="btn-icon fa fa-angle-down"></span>
                                        </button>
                                        <div class="togle-panel" id="filterMedia">
                                            <div class="mb-8">
                                                <label for="photos" class="btn-label">
                                                    <input type="radio" id="photos" name="media" checked>
                                                    <span class="label-text">Foto (<span class="photo-counter">0</span>)</span>
                                                </label>
                                            </div>
                                            <div class="mb-8">
                                                <label for="videos" class="btn-label">
                                                    <input type="radio" id="videos" name="media">
                                                    <span class="label-text">Video (<span class="photo-counter">0</span>)</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-16 toggle-content toggle-nav">
                                        <button class="btn-toggle" type="button" data-toggle="filterArtist">
                                            <span class="btn-text">Artist</span>
                                            <span class="btn-icon fa fa-angle-down"></span>
                                        </button>
                                        <div class="togle-panel" id="filterArtist">
                                            <div class="mb-8">
                                                <label for="Ryan_Putnam" class="btn-label">
                                                    <input type="radio" id="Ryan_Putnam" name="artist" checked>
                                                    <span class="label-text">Ryan Putnam</span>
                                                </label>
                                            </div>
                                            <div class="mb-8">
                                                <label for="Sandro_Shvili" class="btn-label">
                                                    <input type="radio" id="Sandro_Shvili" name="artist">
                                                    <span class="label-text">Sandro Shvili</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bzg_c" data-col="m8, l9">
                            <div class="bzg gallery-container colorbox">
                                <div class="block bzg_c" data-col="m6">
                                    <a href="https://www.youtube.com/embed/kk0WRHV_vt8?rel=0&wmode=transparent" class="video-colorbox responsive-media r-16-9 media-play rounded">
                                        <img src="http://via.placeholder.com/320x180" alt="">
                                    </a>
                                </div>
                                <div class="block bzg_c" data-col="m6">
                                    <a href="https://www.youtube.com/embed/mg2cMqW_hOY?rel=0&wmode=transparent" class="video-colorbox responsive-media r-16-9 media-play rounded">
                                        <img src="http://via.placeholder.com/320x180" alt="">
                                    </a>
                                </div>
                                <div class="block bzg_c" data-col="s6, m4, l3">
                                    <a href="assets/img/site-plan.jpg" class="photo-colorbox responsive-media r-1 rounded">
                                        <img src="https://via.placeholder.com/180x180" alt="">
                                    </a>
                                </div>
                                <div class="block bzg_c" data-col="s6, m4, l3">
                                    <a href="assets/img/hero-bg.jpg" class="photo-colorbox responsive-media r-1 rounded">
                                        <img src="https://via.placeholder.com/180x180" alt="">
                                    </a>
                                </div>
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
