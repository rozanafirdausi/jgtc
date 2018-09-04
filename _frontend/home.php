<!doctype html>
<html class="no-js" lang="en">
<?php include '_partials/head.php'; ?>
<body>
    <!--[if lte IE 9]>
        <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <div class="sticky-footer-container home-container">
        <div class="sticky-footer-container-item">
            <?php include '_partials/header.php'; ?>
        </div>
        <div class="sticky-footer-container-item --pushed">
            <main class="site-main">
                <?php include '_partials/home-hero.php' ?>

                <?php include '_partials/ticket.php'; ?>
                <?php include '_partials/line-up.php'; ?>
                <?php include '_partials/information.php'; ?>
                <?php include '_partials/schedule.php'; ?>
                <?php include '_partials/playlist.php'; ?>
                <?php include '_partials/merchandise.php'; ?>
                <?php include '_partials/story.php'; ?>
                <?php include '_partials/history.php'; ?>
                <?php include '_partials/partner.php'; ?>
            </main>
        </div>
        <div class="sticky-footer-container-item">
            <?php include '_partials/footer.php'; ?>
        </div>
    </div>

    <?php include '_partials/scripts.php'; ?>
</body>
</html>
