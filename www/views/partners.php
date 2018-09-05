<?php
/** @var $urlHandler \DSI\Service\URL */
require __DIR__ . '/header.php' ?>

    <div class="content-block">
        <div class="w-row">
            <div class="w-col w-col-8">
                <h1 class="content-h1"><?php _ehtml('Project partners') ?> </h1>
                <p class="intro">
                    <?php echo str_replace(
                        'ILDA',
                        '<a href="https://idatosabiertos.org/">ILDA</a>',
                        _html("DSI4EU is a project delivered by:")
                    ); ?>
                </p>
                <div class="partner-block w-row">
                    <div class="w-col w-col-3">
                        <img class="partner-logo-colour"
                             src="<?php echo SITE_RELATIVE_PATH ?>/images/partners/bid.png">
                    </div>
                    <div class="w-col w-col-9">
                        <p>
                        <?php _ehtml('bid') ?>
                        </p>
                        <a class="log-in-link long read-more w-clearfix w-inline-block" data-ix="log-in-arrow"
                           href="https://www.iadb.org/es" target="_blank">
                            <div class="login-li long menu-li readmore-li">iadb.org</div>
                            <img class="login-arrow"
                                 src="<?php echo SITE_RELATIVE_PATH ?>/images/ios7-arrow-thin-right.png">
                        </a>
                    </div>
                </div>
                <div class="partner-block w-row">
                    <div class="w-col w-col-3">
                        <img class="partner-logo-colour" src="<?php echo SITE_RELATIVE_PATH ?>/images/partners/avina.jpg">
                    </div>
                    <div class="w-col w-col-9">
                        <p>
                             <?php _ehtml('avina') ?>
                        </p>
                        <a class="log-in-link long read-more w-clearfix w-inline-block" data-ix="log-in-arrow"
                           href="http://www.avina.net/avina/" target="_blank">
                            <div class="login-li long menu-li readmore-li">avina.net</div>
                            <img class="login-arrow"
                                 src="<?php echo SITE_RELATIVE_PATH ?>/images/ios7-arrow-thin-right.png">
                        </a>
                    </div>
                </div>
                <div class="partner-block w-row">
                    <div class="w-col w-col-3">
                        <img class="partner-logo-colour" src="<?php echo SITE_RELATIVE_PATH ?>/images/partners/on.png">
                    </div>
                    <div class="w-col w-col-9">
                        <p>
                             <?php _ehtml('OMIDYAR NETWORK') ?>
                        </p>
                        <a class="log-in-link long read-more w-clearfix w-inline-block" data-ix="log-in-arrow"
                           href="https://www.omidyar.com/" target="_blank">
                            <div class="login-li long menu-li readmore-li">omidyar.com</div>
                            <img class="login-arrow"
                                 src="<?php echo SITE_RELATIVE_PATH ?>/images/ios7-arrow-thin-right.png">
                        </a>
                    </div>
                </div>
                <div class="partner-block w-row">
                    <div class="w-col w-col-3">
                        <img class="partner-logo-colour" src="<?php echo SITE_RELATIVE_PATH ?>/images/partners/altec.png">
                    </div>
                    <div class="w-col w-col-9">
                        <p>
                             <?php _ehtml('altec') ?>
                        </p>
                        <a class="log-in-link long read-more w-clearfix w-inline-block" data-ix="log-in-arrow"
                           href="https://altec.lat/" target="_blank">
                            <div class="login-li long menu-li readmore-li">altec.lat</div>
                            <img class="login-arrow"
                                 src="<?php echo SITE_RELATIVE_PATH ?>/images/ios7-arrow-thin-right.png">
                        </a>
                    </div>
                </div>
                <h3><?php _ehtml('ILDA is part of the Open Data for Development') ?></h3>
                <div class="w-row">
                    <div class="w-col w-col-6">
                        <img style="height: 60px;margin: auto; display: block;" src="<?php echo SITE_RELATIVE_PATH ?>/images/partners/idrc.png">
                    </div>
                    <div class="w-col w-col-6">
                        <img style="height: 60px;margin: auto; display: block;" src="<?php echo SITE_RELATIVE_PATH ?>/images/partners/op4d.png">
                    </div>
                </div>
            </div>
            <?php require __DIR__ . '/partialViews/about-dsi.php' ?>
        </div>
    </div>

<?php require __DIR__ . '/footer.php' ?>