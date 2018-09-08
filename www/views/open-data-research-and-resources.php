<?php
/** @var $urlHandler \DSI\Service\URL */

require __DIR__ . '/header.php';
?>

    <div class="content-block" style="margin-top:200px;">
       <p class="intro">
            <strong>
                <?php _ehtml('If you are interested in further exploring the data behind DSI4EU you can:') ?>
            </strong>
        </p>
        <ul>
            <li><p>
                    <?php _ehtml('Access all the anonymised data we have captured on DSI in Europe via the DSI4EU open data set.') ?>
                </p>
                <p><strong><?php _ehtml('Projects data:') ?></strong>
                    <a href="https://ds.idatosabiertos.org/export/projects.json">json</a>,
                    <a href="https://ds.idatosabiertos.org/export/projects.csv">csv</a>,
                    <a href="https://ds.idatosabiertos.org/export/projects.xml">xml</a>
                </p>
                <p><strong><?php _ehtml('Organisations data:') ?></strong>
                    <a href="https://ds.idatosabiertos.org/export/organisations.json">json</a>,
                    <a href="https://ds.idatosabiertos.org/export/organisations.csv">csv</a>,
                    <a href="https://ds.idatosabiertos.org/export/organisations.xml">xml</a>
                </p>
            </li>
            <li>
                <?php _ehtml('Download the source code. All of the code used to develop this site will be shared') ?>
                <a href="https://github.com/idatosabiertos/DSI4EU" target="_blank"><?php _ehtml('Website') ?></a>
                |
                <a href="https://github.com/idatosabiertos/DSI4EU_Dataviz" target="_blank"><?php _ehtml('Data visualisation') ?></a>
            </li>
        </ul>
        <a class="log-in-link long next-page read-more w-clearfix w-inline-block" data-ix="log-in-arrow"
           href="<?php echo $urlHandler->contactDSI() ?>">
            <div class="login-li long menu-li readmore-li"><?php _ehtml('Contact DSI4EU') ?></div>
            <img class="login-arrow" src="<?php echo SITE_RELATIVE_PATH ?>/images/ios7-arrow-thin-right.png">
        </a>
    </div>

<?php require __DIR__ . '/footer.php' ?>