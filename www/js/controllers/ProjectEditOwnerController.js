angular
    .module(angularAppName)
    .controller('ProjectEditOwnerController', function ($scope, $http, $timeout, $attrs) {
        $scope.save = function () {
            $scope.loading = true;
            $scope.errors = {};

            $http.post(window.location.href, {
                save: true,
                newOwnerID: $('#newOwner').val()
            })
                .then(function (response) {
                    $scope.loading = false;

                    if (response.data.code == 'ok') {
                        swal('Exito!', 'Los cambios se han guardado con éxito.', 'success');
                    } else if (response.data.code == 'error') {
                        $scope.errors = response.data.errors;
                    }
                });
        };
    });