<?php
$pageTitle = 'Terms of use';
require __DIR__ . '/header.php';

$totalProjects = (new \DSI\Repository\ProjectRepoInAPC())->countAll();
$totalOrganisations = (new \DSI\Repository\OrganisationRepoInAPC())->countAll();
?>

    <div class="w-section page-header">
        <div class="w-clearfix container-wide header">
            <h1 class="page-h1 light"><?php _ehtml('Terms of use') ?></h1>
        </div>
    </div>

    <div class="w-section section-grey">
        <div class="container-wide">
            <div class="w-row">
                <div class="w-col w-col-12 intro-col">
                    <p>
                        <?php _ehtml('terms_of_use_p0') ?>
                    </p>
                    <p>
                        <?php _ehtml('terms_of_use_p1') ?>
                    </p>
                    <p>
                        <?php _ehtml('terms_of_use_p2') ?>
                    </p>
                    <p>
                        <?php _ehtml('terms_of_use_p3') ?>
                    </p>
                    <p>
                        <?php _ehtml('terms_of_use_p4') ?>
                    </p>
                    <p>
                        <?php _ehtml('terms_of_use_p5') ?>
                    </p>
                    <p>
                        <?php _ehtml('terms_of_use_p6') ?>
                    </p>
                    <p>
                        <?php _ehtml('terms_of_use_p7') ?>
                    </p>
                    <p>
                        <?php _ehtml('terms_of_use_p8') ?>
                    </p>
                    <p>
                        <?php _ehtml('terms_of_use_p9') ?>
                    </p>
                    <p>
                        <?php _ehtml('terms_of_use_ilda') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

<?php require __DIR__ . '/footer.php' ?>