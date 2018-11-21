angular
    .module(angularAppName)
    .controller('DashboardController', function ($scope, $http, $timeout, $attrs) {
        var url = $attrs.dashboardjsonurl;

        $scope.notifications = {};
        $http.get(url)
            .then(function (response) {
                $scope.notifications = response.data;
            });

        function extractElm(pool, elm) {
            var newPool = [];
            for (var i in pool) {
                if (pool[i].id != elm.id)
                    newPool.push(pool[i]);
            }
            return newPool;
        }

        $scope.notificationsCount = function () {
            return ($scope.notifications.projectInvitations ? $scope.notifications.projectInvitations.length : 0)
                + ($scope.notifications.organisationInvitations ? $scope.notifications.organisationInvitations.length : 0)
                + ($scope.notifications.projectRequests ? $scope.notifications.projectRequests.length : 0)
                + ($scope.notifications.organisationRequests ? $scope.notifications.organisationRequests.length : 0);
        };

        $scope.approveProjectInvitation = function (invitation) {
            $http.post(url, {
                approveProjectInvitation: true,
                projectID: invitation.id
            }).then(function (response) {
                if (response.data.code == 'ok') {
                    swal(response.data.message.title, response.data.message.text, "success");
                    $scope.notifications.projectInvitations =
                        extractElm($scope.notifications.projectInvitations, invitation);
                } else {
                    alert('unexpected error');
                    console.log(response.data);
                }
            });
        };

        $scope.declineProjectInvitation = function (invitation) {
            swal({
                title: "¿Estás seguro?",
                text: "No podrás unirte a este proyecto en este momento.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, continuar!",
                cancelButtonText:"Cancelar",
                closeOnConfirm: false
            }, function () {
                $http.post(url, {
                    rejectProjectInvitation: true,
                    projectID: invitation.id
                }).then(function (response) {
                    if (response.data.code == 'ok') {
                        swal(response.data.message.title, response.data.message.text, "warning");
                        $scope.notifications.projectInvitations =
                            extractElm($scope.notifications.projectInvitations, invitation);
                    } else {
                        alert('unexpected error');
                        console.log(response.data);
                    }
                });
            });
        };

        $scope.approveOrganisationInvitation = function (invitation) {
            $http.post(url, {
                approveOrganisationInvitation: true,
                organisationID: invitation.id
            }).then(function (response) {
                if (response.data.code == 'ok') {
                    swal(response.data.message.title, response.data.message.text, "success");
                    $scope.notifications.organisationInvitations =
                        extractElm($scope.notifications.organisationInvitations, invitation);
                } else {
                    alert('unexpected error');
                    console.log(response.data);
                }
            });
        };

        $scope.declineOrganisationInvitation = function (invitation) {
            swal({
                title: "¿Estás seguro?",
                text: "No podrás unirte a esta organización en este momento.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, Continuar!",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false
            }, function () {
                $http.post(url, {
                    rejectOrganisationInvitation: true,
                    organisationID: invitation.id
                }).then(function (response) {
                    if (response.data.code == 'ok') {
                        swal(response.data.message.title, response.data.message.text, "warning");
                        $scope.notifications.organisationInvitations =
                            extractElm($scope.notifications.organisationInvitations, invitation);
                    } else {
                        alert('unexpected error');
                        console.log(response.data);
                    }
                });
            });
        };

        $scope.approveOrganisationRequest = function (invitation) {
            $http.post(url, {
                approveOrganisationRequest: true,
                organisationID: invitation.organisation.id,
                userID: invitation.user.id
            }).then(function (response) {
                if (response.data.code == 'ok') {
                    swal(response.data.message.title, response.data.message.text, "success");
                    $scope.notifications.organisationRequests =
                        extractElm($scope.notifications.organisationRequests, invitation);
                } else {
                    alert('unexpected error');
                    console.log(response.data);
                }
            });
        };

        $scope.declineOrganisationRequest = function (invitation) {
            swal({
                title: "¿Estás seguro?",
                text: "El usuario no podrá unirse a la organización en este momento.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, Continuar!",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false
            }, function () {
                $http.post(url, {
                    rejectOrganisationRequest: true,
                    organisationID: invitation.organisation.id,
                    userID: invitation.user.id
                }).then(function (response) {
                    if (response.data.code == 'ok') {
                        swal(response.data.message.title, response.data.message.text, "warning");
                        $scope.notifications.organisationRequests =
                            extractElm($scope.notifications.organisationRequests, invitation);
                    } else {
                        alert('unexpected error');
                        console.log(response.data);
                    }
                });
            });
        };

        $scope.approveProjectRequest = function (invitation) {
            $http.post(url, {
                approveProjectRequest: true,
                projectID: invitation.project.id,
                userID: invitation.user.id
            }).then(function (response) {
                if (response.data.code == 'ok') {
                    swal(response.data.message.title, response.data.message.text, "success");
                    $scope.notifications.projectRequests =
                        extractElm($scope.notifications.projectRequests, invitation);
                } else {
                    alert('unexpected error');
                    console.log(response.data);
                }
            });
        };

        $scope.declineProjectRequest = function (invitation) {
            swal({
                title: "¿Estás seguro?",
                text: "El usuario no podrá unirse al proyecto en este momento.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, Continuar!",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false
            }, function () {
                $http.post(url, {
                    rejectProjectRequest: true,
                    projectID: invitation.project.id,
                    userID: invitation.user.id
                }).then(function (response) {
                    if (response.data.code == 'ok') {
                        swal(response.data.message.title, response.data.message.text, "warning");
                        $scope.notifications.projectRequests =
                            extractElm($scope.notifications.projectRequests, invitation);
                    } else {
                        alert('unexpected error');
                        console.log(response.data);
                    }
                });
            });
        };

        $scope.terminateAccount = function () {
            swal({
                    title: "",
                    text: translate.get("¿Estás seguro de que quieres cancelar tu cuenta?"),
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Si",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                },
                function () {
                    $http.post(url, {terminateAccount: true})
                        .then(function (response) {
                            if (response.data.code == 'ok') {
                                swal(
                                    "",
                                    translate.get("Se le enviará un correo electrónico para confirmar su solicitud."),
                                    "success"
                                );
                            } else {
                                swal("Info", Object.values(response.data.errors).join(' '), "info");
                            }
                        });
                });
        }
    });