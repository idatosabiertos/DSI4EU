<?php
require __DIR__ . '/header.php';
/** @var $loggedInUser \DSI\Entity\User */
/** @var $urlHandler \DSI\Service\URL */
/** @var $contentUpdates \DSI\Entity\ContentUpdate[] */

?>
    <div ng-controller="WaitingApprovalController"
         data-listjsonurl="<?php echo $urlHandler->waitingApproval('json') ?>">
        <div class="content-block">
            <div class="w-row">
                <div class="w-col w-col-8 w-col-stack">
                    <h1 class="content-h1"><?php _ehtml('Waiting Approval') ?></h1>
                </div>
            </div>
        </div>

        <div class="content-directory">
            <div class="list-block">
                <div class="w-row">
                    <form class="w-col w-col-12" action="" method="post">
                        <div class="w-row">
                            <div ng-if="items.length > 0">
                                <div ng-repeat="item in items" class="w-col w-col-4 w-col-stack">
                                    <div class="info-card left small w-inline-block">
                                        <h3 class="info-card-h3">
                                            <label>
                                                <input type="checkbox" name="id[]"
                                                       value="{{item.id}}"
                                                       ng-checked="item.checked"/>
                                                {{ item.name }}
                                            </label>
                                        </h3>
                                        <div style="float:right;font-size:10px;margin:-10px 10px">
                                            <a href="{{item.url}}" target="_blank">Ver</a>
                                            &nbsp;&nbsp;
                                            <a href="#" ng-click="approveItem(item)" style="color:#1dc9a0">Aprobar</a>
                                            &nbsp;&nbsp;
                                            <a href="#" ng-click="rejectItem(item)" style="color:red">Declinar</a>
                                        </div>
                                        <div class="involved-tag" style="left:10px;width:100px">
                                            <span ng-if="item.updated === '<?= \DSI\Entity\ContentUpdate::New_Content ?>'">
                                                <span ng-if="item.projectID">Nuevo Proyecto</span>
                                                <span ng-if="item.organisationID">Nueva Organización</span>
                                            </span>
                                            <span ng-if="item.updated === '<?= \DSI\Entity\ContentUpdate::Updated_Content ?>'">
                                                <span ng-if="item.projectID">Proyecto actualizado</span>
                                                <span ng-if="item.organisationID">Organización actualizada</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div ng-if="items.length == 0">
                                <?php _ehtml('No results found.') ?>
                            </div>
                        </div>
                        <div class="w-row" ng-if="items.length > 0">
                            <a href="#" ng-click="selectAll()">Seleccionar todo</a>
                            &nbsp;&nbsp;
                            <a href="#" ng-click="deselectAll()">Deseleccionar todo</a>
                        </div>
                        <div class="w-row" style="margin-top:20px" ng-if="items.length > 0">
                            <button type="submit" name="submit" value="approve">Aprobar todo lo seleccionado</button>
                            <button type="submit" name="submit" value="reject">Eliminar todo lo seleccionado</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript"
            src="<?php echo SITE_RELATIVE_PATH ?>/js/controllers/WaitingApprovalController.js?<?php \DSI\Service\Sysctl::echoVersion() ?>"></script>

<?php require __DIR__ . '/footer.php' ?>