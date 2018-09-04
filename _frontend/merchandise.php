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
                            <h3 class="mb-0 font-normal text-maroon">For Sell</h3>
                            <h1 class="text-caps font-secondary main-title">
                                <span>Merchandise</span>
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="mb-24 bzg">
                        <?php for ($i=1; $i <= 12; $i++) { ?>
                        <div class="block bzg_c text-center" data-col="m3">
                            <h4 class="mb-0"><a href="#" class="link-black text-ellipsis">
                                Official Album JGTC
                            </a></h4>
                            <p class="mb-0 text-grey">IDR 74.000</p>
                            <a href="#" class="btn btn--block btn--iconic link-maroon" title="Add to Cart">
                                <span class="fas fa-shopping-cart" aria-hidden="true"></span>
                            </a>
                            <figure>
                                <a href="#">
                                    <img src="assets/img/merchandise.png" alt="">
                                </a>
                            </figure>
                        </div>
                        <?php } ?>
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
