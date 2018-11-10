<?php
$pageTitle = 'Privacy Policy';
require __DIR__ . '/header.php';

$totalProjects = (new \DSI\Repository\ProjectRepoInAPC())->countAll();
$totalOrganisations = (new \DSI\Repository\OrganisationRepoInAPC())->countAll();
?>

    <div class="w-section page-header">
        <div class="w-clearfix container-wide header">
            <h1 class="page-h1 light"><?php _ehtml('Privacy policy') ?></h1>
        </div>
    </div>

    <div class="w-section section-grey">
        <div class="container-wide">
            <div class="w-row">
                <div class="w-col w-col-12 intro-col">
                    <p>
                        <?php _ehtml('privacy_policy_p0') ?>
                    </p>

                    <h2 class="home-h2"><?php _ehtml('privacy_policy_p1_q') ?></h2>
                    <p>
                        <?php _ehtml('privacy_policy_p1') ?>
                    </p>

                    <h2 class="home-h2"><?php _ehtml('privacy_policy_p2_q') ?></h2>
                    <p>
                        <?php _ehtml('privacy_policy_p2') ?>
                    </p>

                    <h2 class="home-h2"><?php _ehtml('privacy_policy_p3_q') ?></h2>
                    <p>
                        <?php _ehtml('privacy_policy_p3') ?>
                    </p>

                    <h2 class="home-h2"><?php _ehtml('privacy_policy_p4_q') ?></h2>
                    <p>
                        <?php _ehtml('privacy_policy_p4') ?>
                    </p>

                    <p>
                        <?php _ehtml('privacy_policy_p4_1') ?>
                    </p>

                    <p>
                        <?php _ehtml('privacy_policy_p4_2') ?>
                    </p>

                    <h2 class="home-h2"><?php _ehtml('privacy_policy_p5_q') ?></h2>
                    <p>
                        <?php _ehtml('privacy_policy_p5') ?>
                    </p>

                    <p>
                        <?php _ehtml('privacy_policy_p5_1') ?>
                    </p>

                    <h2 class="home-h2"><?php _ehtml('privacy_policy_p6_q') ?></h2>
                    <p>
                        <?php _ehtml('privacy_policy_p6') ?>
                    </p>

                    <h2 class="home-h2"><?php _ehtml('privacy_policy_p7_q') ?></h2>
                    <p>
                        <?php _ehtml('privacy_policy_p7') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

<?php require __DIR__ . '/footer.php' ?>