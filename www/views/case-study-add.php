<?php
require __DIR__ . '/header.php';
/** @var $loggedInUser \DSI\Entity\User */
/** @var $projects \DSI\Entity\Project[] */
/** @var $organisations \DSI\Entity\Organisation[] */
?>

    <div ng-controller="CaseStudyAddController">
        <div class="content-block">
            <div class="w-row">
                <div class="w-col w-col-8">
                    <h1 class="content-h1">Agregar nuevo caso de estudio</h1>
                </div>
                <div class="sidebar w-col w-col-4">
                    <h1 class="content-h1">Acciones</h1>
                    <a class="sidebar-link" href="<?php echo $urlHandler->caseStudies() ?>">
                        <span class="green">-&nbsp;</span>Cancelar
                    </a>
                </div>
            </div>
        </div>
        <div class="content-directory">
            <div class="container-wide step-window">
                <div class="w-form">
                    <form id="email-form-2" name="email-form-2" ng-submit="add()">
                        <div class="w-row">
                            <div class="form-col-left w-col w-col-6">
                                <h2 class="edit-h2">Texto del caso de estudio</h2>
                                <label>Título:</label>
                                <input class="creator-data-entry w-input" id="name-2" maxlength="256"
                                       ng-model="caseStudy.title"
                                       name="name-2" placeholder="Título" type="text">
                                <div class="error" ng-bind="errors.title"></div>
                                <label>Texto de introducción:</label>
                                <input class="creator-data-entry w-input" data-name="Name 3" id="name-3" maxlength="256"
                                       name="name-3" placeholder="Este texto aparece en la tarjeta de introducción"
                                       ng-model="caseStudy.introCardText" type="text">
                                <label for="field">Introducción de la página:</label>
                                <textarea class="creator-data-entry w-input" name="field"
                                          placeholder="Este texto aparece en la parte superior de la página del caso de estudio"
                                          id="pageIntro" ng-model="caseStudy.introPageText"></textarea>
                                <br/>
                                <label>Vista general de la página:</label>
                                <textarea class="creator-data-entry end long-description w-input"
                                          id="mainText" ng-model="caseStudy.mainText"
                                          placeholder="Este es el texto principal"></textarea>

                                <br/>
                                <h2 class="edit-h2">Proyecto</h2>
                                <select class="creator-data-entry w-input" ng-model="caseStudy.projectID">
                                    <option value="0"> - Seleccione uno - </option>
                                    <?php foreach ($projects AS $project) { ?>
                                        <option value="<?php echo $project->getId() ?>">
                                            <?php echo show_input($project->getName()) ?>
                                        </option>
                                    <?php } ?>
                                </select>

                                <br/>
                                <h2 class="edit-h2">Organización</h2>
                                <select class="creator-data-entry w-input" ng-model="caseStudy.organisationID">
                                    <option value="0"> - Seleccione una -</option>
                                    <?php foreach ($organisations AS $organisation) { ?>
                                        <option value="<?php echo $organisation->getId() ?>">
                                            <?php echo show_input($organisation->getName()) ?>
                                        </option>
                                    <?php } ?>
                                </select>

                            </div>
                            <div class="form-col-right w-col w-col-6">
                                <h2 class="edit-h2">Info</h2>

                                <label for="name-3">Texto:</label>
                                <textarea class="creator-data-entry w-input" ng-model="caseStudy.infoText"></textarea>

                                <label for="name-9">Enlace externo</label>
                                <input class="creator-data-entry w-input" data-name="Name 9" id="name-9" maxlength="256"
                                       ng-model="caseStudy.url"
                                       name="name-9" placeholder="https://example.org" type="text">

                                <label for="name-8">Enlace de texto</label>
                                <input class="creator-data-entry end w-input" data-name="Name 8" id="name-8"
                                       maxlength="256" name="name-8"
                                       ng-model="caseStudy.buttonLabel"
                                       placeholder="Este texto aparecerá en el botón del enlace de arriba"
                                       type="text">

                                <h2 class="edit-h2">Aspectos visuales</h2>
                                <div class="w-row">
                                    <?php /* <div class="w-col w-col-4">
                                        <label for="name-8">Agregar logo</label>
                                        <img class="story-image-upload"
                                             style="max-height:140px;max-width:140px"
                                             src="https://d3e54v103j8qbb.cloudfront.net/img/image-placeholder.svg"
                                             ng-src="{{logo.image}}">
                                        <a class="w-button dsi-button story-image-upload" href="#"
                                           ngf-select="logo.upload($file, $invalidFiles)"
                                           ng-bind="logo.loading ? 'Cargando...' : 'Subir imagen'">Subir imagen
                                        </a>
                                        <div style="color:red" ng-show="logo.errorMsg.file" ng-cloak>
                                            {{logo.errorMsg.file}}
                                        </div>
                                    </div> */ ?>
                                    <div class="w-col w-col-4">
                                        <label for="name-8">Añadir imagen de fondo</label>
                                        <img class="story-image-upload"
                                             style="max-height:140px;max-width:140px"
                                             src="https://d3e54v103j8qbb.cloudfront.net/img/image-placeholder.svg"
                                             ng-src="{{cardImage.image}}">
                                        <a class="w-button dsi-button story-image-upload" href="#"
                                           ngf-select="cardImage.upload($file, $invalidFiles)"
                                           ng-bind="cardImage.loading ? 'Cargando...' : 'Subir imagen'">Subir imagen
                                        </a>
                                        <div style="color:red" ng-show="cardImage.errorMsg.file" ng-cloak>
                                            {{cardImage.errorMsg.file}}
                                        </div>
                                    </div>
                                    <?php /* <div class="w-col w-col-4">
                                        <label for="name-8">Agregar imagen de encabezado</label>
                                        <img class="story-image-upload"
                                             style="max-height:140px;max-width:140px"
                                             src="https://d3e54v103j8qbb.cloudfront.net/img/image-placeholder.svg"
                                             ng-src="{{headerImage.image}}">
                                        <a class="w-button dsi-button story-image-upload" href="#"
                                           ngf-select="headerImage.upload($file, $invalidFiles)"
                                           ng-bind="headerImage.loading ? 'Cargando...' : 'Subir imagen'">Subir imagen
                                        </a>
                                        <div style="color:red" ng-show="headerImage.errorMsg.file" ng-cloak>
                                            {{headerImage.errorMsg.file}}
                                        </div>
                                    </div> */ ?>
                                </div>

                                <?php /*
                                <label for="name-8">Color de tarjeta</label>
                                 <input class="creator-data-entry end w-input" style="width:100px;height:100px"
                                       value="#000000"
                                       ng-model="caseStudy.cardColour"
                                       type="color">
                                */ ?>

                                <h2 class="edit-h2">Publicación</h2>
                                <label for="name-8">Publica tu caso de estudio</label>
                                <div class="w-radio">
                                    <label class="w-form-label">
                                        <input class="w-radio-input" name="isPublished"
                                               type="radio"
                                               ng-model="caseStudy.isPublished"
                                               value="1">
                                        Si
                                    </label>
                                </div>
                                <div class="w-radio">
                                    <label class="w-form-label">
                                        <input class="w-radio-input" name="isPublished"
                                               type="radio"
                                               ng-model="caseStudy.isPublished"
                                               value="0">
                                        No
                                    </label>
                                </div>

                                <br/>
                                <label for="name-8">Publicar en la primera página</label>
                                <div class="w-radio">
                                    <label class="w-form-label">
                                        <input class="w-radio-input" name="positionOnHomePage" type="radio"
                                               ng-model="caseStudy.positionOnHomePage" value="0">
                                        No publicar en 1ª posición
                                    </label>
                                </div>
                                <div class="w-radio">
                                    <label class="w-form-label">
                                        <input class="w-radio-input" name="positionOnHomePage" type="radio"
                                               ng-model="caseStudy.positionOnHomePage" value="1">
                                        Publicar en 1ª posición
                                    </label>
                                </div>
                                <div class="w-radio">
                                    <label class="w-form-label">
                                        <input class="w-radio-input" name="positionOnHomePage" type="radio"
                                               ng-model="caseStudy.positionOnHomePage" value="2">
                                        Publicar en 2ª posición
                                    </label>
                                </div>
                                <div class="w-radio">
                                    <label class="w-form-label">
                                        <input class="w-radio-input" name="positionOnHomePage" type="radio"
                                               ng-model="caseStudy.positionOnHomePage" value="3">
                                        Publicar en 3ª posición
                                    </label>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="tabbed-nav-buttons w-clearfix">
                    <input type="submit" class="tab-button-2 tab-button-next w-button" value="Agregar"/>
                </div>
                </form>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script type="text/javascript"
            src="<?php echo SITE_RELATIVE_PATH ?>/js/controllers/CaseStudyAddController.js?<?php \DSI\Service\Sysctl::echoVersion() ?>"></script>

    <script>
        $(function () {
            tinymce.init({
                selector: '#mainText, #pageIntro',
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

            $("#projectStartDate").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+20"
            });
            $("#projectEndDate").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+20"
            });
        });
    </script>

<?php require __DIR__ . '/footer.php' ?>