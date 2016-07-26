<script type="text/javascript"
        src="<?php echo SITE_RELATIVE_PATH ?>/js/controllers/CreateProjectOrganisationController.js?<?php \DSI\Service\Sysctl::echoVersion() ?>"></script>

<div ng-controller="CreateProjectOrganisationController">
    <div class="create-project-modal modal">
        <div class="modal-container">
            <div class="modal-helper">
                <div class="modal-content">
                    <h2 class="centered modal-h2">Create project</h2>
                    <div class="w-form">
                        <form id="email-form-3" name="email-form-3" ng-submit="createProject()">
                            <div style="color:red;text-align:center" ng-show="project.errors.name"
                                 ng-bind="project.errors.name"></div>
                            <input class="w-input modal-input" id="name-3" maxlength="256"
                                   name="name" placeholder="Enter the name of your project" type="text"
                                   ng-model="project.name" ng-class="{error: project.errors.name}">
                            <input class="w-button dsi-button creat-button" type="submit"
                                   value="Create +"
                                   ng-value="project.loading ? 'Loading...' : 'Create +'"
                                   ng-disabled="project.loading">
                        </form>
                    </div>
                    <div class="cancel" data-ix="close-nu-modal">Cancel</div>
                </div>
            </div>
        </div>
    </div>
    <div class="create-organisation-modal modal">
        <div class="modal-container">
            <div class="modal-helper">
                <div class="modal-content">
                    <h2 class="centered modal-h2">Create organisation</h2>
                    <div class="w-form">
                        <form id="email-form-3" name="email-form-3" ng-submit="createOrganisation()">
                            <div style="color:red;text-align:center" ng-show="organisation.errors.name"
                                 ng-bind="organisation.errors.name"></div>
                            <input class="w-input modal-input" id="name-3" maxlength="256"
                                   name="name" placeholder="Enter the name of your organisation" type="text"
                                   ng-model="organisation.name"
                                   ng-class="{error: organisation.errors.name}">
                            <input class="w-button dsi-button creat-button" data-wait="Please wait..." type="submit"
                                   value="Create +"
                                   ng-value="organisation.loading ? 'Loading...' : 'Create +'"
                                   ng-disabled="organisation.loading">
                        </form>
                    </div>
                    <div class="cancel" data-ix="close-nu-modal">Cancel</div>
                </div>
            </div>
        </div>
    </div>
</div>
