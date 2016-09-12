<?php
require __DIR__ . '/header.php';
/** @var $loggedInUser \DSI\Entity\User */
?>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <div ng-controller="EventAddController">
        <div class="header-section-grey w-section">
            <div class="container-wide">
                <h1 class="header-centre">Add a new event</h1>
            </div>
        </div>
        <div class="section-white w-section">
            <div class="container-wide step-window">
                <form id="email-form-2" name="email-form-2" ng-submit="add()">
                    <div class="w-form">
                        <div class="w-row">
                            <div class="form-col-left w-col w-col-6">
                                <h2 class="edit-h2">Event text</h2>

                                <label for="name-2">Event title:</label>
                                <input class="creator-data-entry w-input" id="name-2" maxlength="256"
                                       ng-model="event.title"
                                       name="name-2" placeholder="Event title" type="text">
                                <div class="error" ng-bind="errors.title"></div>

                                <label for="name-3">Event link:</label>
                                <input class="creator-data-entry w-input" data-name="Name 3" id="name-3" maxlength="256"
                                       ng-model="event.url"
                                       name="name-3" placeholder="Event link" type="text">
                                <div class="error" ng-bind="errors.url"></div>

                                <label>Short description</label>
                                <textarea class="creator-data-entry end long-description w-input"
                                          id="shortDescription"
                                          ng-model="event.shortDescription"
                                          data-placeholder="Short description"></textarea>
                                <div class="error" ng-bind="errors.shortDescription"></div>

                                <br />
                                <label>Event description</label>
                                <textarea class="creator-data-entry end long-description w-input"
                                          id="description"
                                          ng-model="event.description"
                                          data-placeholder="Event description"></textarea>
                                <div class="error" ng-bind="errors.description"></div>
                            </div>
                            <div class="form-col-right w-col w-col-6">
                                <h2 class="edit-h2">Event details</h2>

                                <label for="name-4">Event start date</label>
                                <input class="creator-data-entry w-input" data-name="Name 4" id="startDate"
                                       maxlength="256"
                                       ng-model="event.startDate"
                                       name="name-4" placeholder="When is the event first day" type="text">
                                <div class="error" ng-bind="errors.startDate"></div>

                                <label for="name-4">Event end date</label>
                                <input class="creator-data-entry w-input" data-name="Name 4" id="endDate"
                                       maxlength="256"
                                       ng-model="event.endDate"
                                       name="name-4" placeholder="When is the event last day" type="text">
                                <div class="error" ng-bind="errors.endDate"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tabbed-nav-buttons w-clearfix">
                        <input type="submit" class="tab-button-2 tab-button-next w-button" value="Save and continue"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script type="text/javascript"
            src="<?php echo SITE_RELATIVE_PATH ?>/js/controllers/EventAddController.js?<?php \DSI\Service\Sysctl::echoVersion() ?>"></script>

    <script>
        $(function () {
            $('select.select2').select2();

            tinymce.init({
                selector: '#description',
                statusbar: false,
                height: 500,
                plugins: "autoresize autolink lists link preview paste textcolor colorpicker image imagetools media",
                autoresize_bottom_margin: 0,
                autoresize_max_height: 500,
                menubar: false,
                toolbar1: 'styleselect | forecolor backcolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | preview',
                image_advtab: true,
                paste_data_images: false
            });

            $("#startDate, #endDate").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+20"
            });
        });
    </script>

<?php require __DIR__ . '/footer.php' ?>