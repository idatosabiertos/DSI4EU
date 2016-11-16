<?php
require __DIR__ . '/header.php';
/** @var $loggedInUser \DSI\Entity\User */
/** @var $urlHandler \DSI\Service\URL */

$showAdvancedSearch = (
    isset($_GET['q']) OR
    isset($_GET['tag']) OR
    isset($_GET['helpTag']) OR
    isset($_GET['techTag'])
);
?>
    <div ng-controller="ProjectsController"
         data-projectsjsonurl="<?php echo $urlHandler->projectsJson() ?>"
         data-projecttagsjsonurl="<?php echo $urlHandler->projectTagsJson() ?>"
         data-searchname="<?php echo show_input($_GET['q'] ?? '') ?>"
         data-searchtag="<?php echo show_input($_GET['tag'] ?? '0') ?>"
         data-searchhelptag="<?php echo show_input($_GET['helpTag'] ?? '0') ?>"
         data-searchtechtag="<?php echo show_input($_GET['techTag'] ?? '0') ?>"
         data-showadvancedsearch="<?php echo (bool)$showAdvancedSearch ?>">

        <div class="content-block">
            <div class="w-row">
                <div class="w-col w-col-8 w-col-stack">
                    <h1 class="content-h1">Projects</h1>
                    <p class="intro">
                        Digital social innovation (DSI) covers a range of areas, from providing tools to
                        improve democratic processes to helping citizens measure pollution in their local environment,
                        and
                        from crowdfunding community projects to creating platforms to scrutinise public spending.
                    </p>
                    <p class="header-intro-descr">
                        Here you can look through projects which digital social innovators
                        across Europe have submitted to the website. You can filter them by the four categories of
                        digital social innovation which we have identified:
                        <strong>Open hardware</strong>,
                        <strong>Open networks</strong>,
                        <strong>Open data</strong> and
                        <strong>Open knowledge</strong>.
                    </p>
                </div>
                <div class="sidebar w-col w-col-4 w-col-stack">
                    <h1 class="content-h1 side-bar-space-h1">Add your project</h1>
                    <p>Showcase your current and past work, identify potential collaborations and link your projects to
                        your organisation.</p>
                    <?php if ($loggedInUser) { ?>
                        <a class="log-in-link long read-more w-clearfix w-inline-block"
                           data-ix="create-project-modal" href="#">
                            <div class="login-li long menu-li readmore-li">Add your project</div>
                            <img class="login-arrow"
                                 src="<?php echo SITE_RELATIVE_PATH ?>/images/ios7-arrow-thin-right.png">
                        </a>
                    <?php } else { ?>
                        <a class="log-in-link long read-more w-clearfix w-inline-block"
                           href="<?php echo $urlHandler->login() ?>?from=project">
                            <div class="login-li long menu-li readmore-li">Add your project</div>
                            <img class="login-arrow"
                                 src="<?php echo SITE_RELATIVE_PATH ?>/images/ios7-arrow-thin-right.png">
                        </a>
                    <?php } ?>
                </div>
            </div>
            <div class="alphabet-selectors w-clearfix">
                <a href="#" class="w-inline-block alphabet-link" style="width:50px"
                   ng-class="{selected: startLetter == ''}"
                   ng-click="setStartLetter('')">
                    <div>All</div>
                </a>
                <a href="#" class="w-inline-block alphabet-link"
                   ng-class="{selected: startLetter == letter}"
                   ng-repeat="letter in letters"
                   ng-click="setStartLetter(letter)">
                    <div ng-bind="letter"></div>
                </a>
            </div>
        </div>

        <div class="content-directory">
            <div class="list-block">
                <div class="w-row">
                    <div class="filter-col-left w-col w-col-4">
                        <div class="filter-bar info-card">
                            <div class="w-form">
                                <form id="email-form" name="email-form">
                                    <h3 class="sidebar-h3">Filter projects</h3>
                                    <div class="search-div">
                                        <input class="sidebar-search-field w-input" data-ix="hide-search-icon"
                                               data-name="Search" id="Search" maxlength="256" name="Search"
                                               placeholder="Search by keyword, type or project" type="text"
                                               ng-model="searchName">
                                        <img class="search-mag"
                                             src="<?php echo SITE_RELATIVE_PATH ?>/images/ios7-search.png">
                                    </div>

                                    <div>
                                        <div class="advanced-search w-row">
                                            <div class="w-col w-col-6">
                                                <a class="w-clearfix w-inline-block" href="#"
                                                   ng-click="showAdvancedSearch = !showAdvancedSearch">
                                                    <div class="adv-text">Advanced filters</div>
                                                    <div ng-class="{showAdvancedSearch: showAdvancedSearch}"
                                                         class="arrow advancedSearchArrow"></div>
                                                </a>
                                            </div>
                                            <div class="w-col w-col-6"></div>
                                        </div>
                                        <div class="adv-options" ng-show="showAdvancedSearch">
                                            <label>Country</label>
                                            <select class="w-select" id="field" name="field"
                                                    ng-model="filter.countryID">
                                                <option value="0">- Select one country -</option>
                                                <option ng-repeat="country in countries" value="{{country.id}}">
                                                    {{country.text}}
                                                </option>
                                            </select>

                                            <label>Tag</label>
                                            <select class="w-select" id="field" name="field" ng-model="filter.tagID">
                                                <option value="0">- Select a tag-</option>
                                                <option ng-repeat="tag in tags.tags" value="{{tag.id}}">
                                                    {{tag.name}}
                                                </option>
                                            </select>

                                            <label>Impact Help</label>
                                            <select class="w-select" id="field" name="field"
                                                    ng-model="filter.helpTagID">
                                                <option value="0">- Select a tag -</option>
                                                <option ng-repeat="tag in tags.impactTags" value="{{tag.id}}">
                                                    {{tag.name}}
                                                </option>
                                            </select>

                                            <label>Technology</label>
                                            <select class="w-select" id="field" name="field"
                                                    ng-model="filter.techTagID">
                                                <option value="0">- Select a tag -</option>
                                                <option ng-repeat="tag in tags.impactTags" value="{{tag.id}}">
                                                    {{tag.name}}
                                                </option>
                                            </select>

                                            <br/>
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="filter-title"><strong>Filter by category</strong>
                                    </div>
                                    <div class="filter-checkbox w-checkbox">
                                        <input class="w-checkbox-input" data-name="Checkbox 2" id="checkbox-2"
                                               name="checkbox-2" ng-model="dsiFocus35"
                                               type="checkbox">
                                        <label class="w-form-label" for="checkbox-2">Open hardware</label>
                                    </div>
                                    <div class="trend-notes">The use of open hardware and maker spaces to develop, make,
                                        adapt,
                                        hack and shape tools for social change
                                    </div>
                                    <div class="filter-checkbox w-checkbox">
                                        <input class="w-checkbox-input" data-name="Checkbox 5" id="checkbox-5"
                                               name="checkbox-5" ng-model="dsiFocus9"
                                               type="checkbox">
                                        <label class="w-form-label" for="checkbox-5">Open networks</label>
                                    </div>
                                    <div class="trend-notes">New networks and infrastructures, e.g. sensor networks,
                                        where
                                        people connect their devices such as phones and internet modems to collectively
                                        share
                                        resources and solve problems
                                    </div>
                                    <div class="filter-checkbox w-checkbox">
                                        <input class="w-checkbox-input" data-name="Checkbox 4" id="checkbox-4"
                                               name="checkbox-4" ng-model="dsiFocus8"
                                               type="checkbox">
                                        <label class="w-form-label" for="checkbox-4">Open data</label>
                                    </div>
                                    <div class="trend-notes">Innovative ways of opening up, capturing, using, analysing
                                        and
                                        interpreting open data
                                    </div>
                                    <div class="filter-checkbox w-checkbox">
                                        <input class="w-checkbox-input" data-name="Checkbox 3" id="checkbox-3"
                                               name="checkbox-3" ng-model="dsiFocus4"
                                               type="checkbox">
                                        <label class="w-form-label" for="checkbox-3">Open knowledge</label>
                                    </div>
                                </form>
                            </div>
                            <div class="trend-notes">Where people come together through online platforms to
                                crowdsource or
                                crowdfund solutions, collectively analyse data and develop new DSI projects
                            </div>
                        </div>
                    </div>
                    <div class="w-col w-col-8">
                        <div class="w-row">
                            <div class="w-col w-col-6 w-col-stack">
                                <a class="info-card left small w-inline-block" href="{{project.url}}"
                                   ng-repeat="project in projects
                                   | filter: startsWithLetter
                                   | filter: searchName
                                   | filter: projectHasDsiFocusTag()
                                   | filter: projectInCountry()
                                   | filter: projectHasTag()
                                   | filter: projectHasHelpTag()
                                   | filter: projectHasTechTag()
                                   as filtered"
                                   ng-if="$index < (filtered.length / 2)">
                                    <h3 class="info-card-h3" ng-bind="project.name"></h3>
                                    <div class="involved-tag">
                                        <span ng-bind="project.organisationsCount"></span>
                                        <span
                                            ng-bind="project.organisationsCount == 1 ? 'Organisation' : 'Organisations'">
                                        involved
                                    </div>
                                </a>
                            </div>
                            <div class="w-col w-col-6 w-col-stack">
                                <a class="info-card left small w-inline-block" href="{{project.url}}"
                                   ng-repeat="project in projects
                                   | filter: startsWithLetter
                                   | filter: searchName
                                   | filter: projectHasDsiFocusTag()
                                   | filter: projectInCountry()
                                   | filter: projectHasTag()
                                   | filter: projectHasHelpTag()
                                   | filter: projectHasTechTag()
                                   as filtered"
                                   ng-if="$index >= (filtered.length / 2)">
                                    <h3 class="info-card-h3" ng-bind="project.name"></h3>
                                    <div class="involved-tag">
                                        <span ng-bind="project.organisationsCount"></span>
                                        <span
                                            ng-bind="project.organisationsCount == 1 ? 'Organisation' : 'Organisations'">
                                        involved
                                    </div>
                                </a>
                            </div>

                            <div ng-show="filtered.length == 0" ng-cloak>
                                No results found.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript"
            src="<?php echo SITE_RELATIVE_PATH ?>/js/controllers/ProjectsController.js?<?php \DSI\Service\Sysctl::echoVersion() ?>"></script>

<?php require __DIR__ . '/footer.php' ?>