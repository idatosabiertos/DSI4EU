angular
    .module(angularAppName)
    .controller('ResetPasswordController', function ($scope, $http, $timeout, $attrs) {
        $scope.data = {};

        $scope.submit = function () {
            $scope.loading = true;
            $scope.errors = {};
            var data = $scope.data;
            data.save = true;

            $http.post(window.location.href, data).then(
                function (response) {
                    $scope.loading = false;
                    if (response.data.code == 'error') {
                        $scope.errors = response.data.errors;
                    } else if (response.data.code == 'ok') {
                        swal({
                            title: "Exito",
                            text: "Su contraseña se ha establecido correctamente.",
                            type: "success"
                        }, function () {
                            window.location.href = response.data.url;
                        });
                    }
                },
                function (response) {
                    $scope.loading = false;
                    alert('unexpected error');
                    console.log(response);
                }
            )
        };
    });