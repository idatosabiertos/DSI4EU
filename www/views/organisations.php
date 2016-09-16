<?php
require __DIR__ . '/header.php'
/** @var $loggedInUser \DSI\Entity\User */
?>
    <script type="text/javascript"
            src="<?php echo SITE_RELATIVE_PATH ?>/js/controllers/OrganisationsController.js?<?php \DSI\Service\Sysctl::echoVersion() ?>"></script>

    <div ng-controller="OrganisationsController"
         data-organisationsjsonurl="<?php echo $urlHandler->organisations('json') ?>">

        <div class="w-section page-header stories-header">
            <div class="container-wide header">
                <h1 class="page-h1 light">Organisations</h1>
                <div class="w-clearfix alphabet-selectors">
                    <a href="#" class="w-inline-block alphabet-link"
                       ng-class="{selected: startLetter == letter}"
                       ng-repeat="letter in letters"
                       ng-click="setStartLetter(letter)">
                        <div ng-bind="letter"></div>
                    </a>
                    <?php if ($loggedInUser) { ?>
                        <a class="w-button dsi-button top-filter add-new-story" href="#"
                           data-ix="create-organisation-modal">Add organisation +</a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="w-section project-archive">
            <div class="container-wide archive">
                <div class="w-row card-row">
                    <div ng-hide="loaded" style="padding: 0 10px 10px 20px;font-weight: bold;">Loading...</div>
                    <div class="w-col w-col-4 w-col-stack"
                         ng-repeat="organisation in organisations | filter:startsWithLetter">
                        <a ng-href="{{organisation.url}}" class="w-inline-block card-thin">
                            <div class="w-row">
                                <div class="w-col w-col-4 w-col-small-6 w-col-tiny-6">
                                    <img width="50" src="<?php echo \DSI\Entity\Image::ORGANISATION_LOGO_URL?>{{organisation.logo}}" class="card-logo-small">
                                </div>
                                <div class="w-col w-col-8 w-col-small-6 w-col-tiny-6 card-slim-info">
                                    <h2 class="card-slim-h2" ng-bind="organisation.name"></h2>
                                    <div class="card-slim-location" ng-show="organisation.region && organisation.country"
                                         ng-bind="organisation.region + ', ' + organisation.country"></div>
                                    <div class="w-row card-slim-stats">
                                        <div class="w-col w-col-4 w-col-medium-6 w-col-small-6 w-col-tiny-6">
                                            <div>
                                                <strong ng-bind="organisation.projectsCount"></strong>
                                                <span
                                                    ng-bind="organisation.projectsCount == 1 ? 'Project' : 'Projects'">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="w-col w-col-8 w-col-medium-6 w-col-small-6 w-col-tiny-6">
                                            <div>
                                                <strong ng-bind="organisation.partnersCount"></strong>
                                                <span
                                                    ng-bind="organisation.partnersCount == 1 ? 'Partner' : 'Partners'">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php require __DIR__ . '/footer.php' ?>