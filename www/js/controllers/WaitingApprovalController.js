angular
  .module(angularAppName)
  .controller('WaitingApprovalController', function ($scope, $http, $attrs) {
    var Helpers = {
      getFirstNonEmptyValue: function (values) {
        for (var i in values) {
          if (values[i] != '')
            return values[i];
        }
        return null;
      },
      getItemIndexById: function (pool, id) {
        for (var i in pool) {
          if (pool[i].id == id)
            return i;
        }
        return -1;
      },
      swalWarning: function (data) {
        data.options.type = "warning";
        data.options.showCancelButton = true;
        data.optionscloseOnConfirm = false;
        data.options.showLoaderOnConfirm = true;

        swal(data.options, function () {
          $http
            .post(window.location.href, {
              getSecureCode: true
            })
            .then(function (response) {
              if (response.data.code === 'ok') {
                receivedCode(response.data.secureCode)
              } else {
                alert('unexpected error');
                console.log(response.data)
              }
            });

          function receivedCode(secureCode) {
            data.post.secureCode = secureCode;
            $http
              .post(window.location.href, data.post)
              .then(function (response) {
                if (response.data.code === 'ok') {
                  success()
                } else {
                  alert('unexpected error');
                  console.log(response.data)
                }
              })
          }

          function success() {
            data.success.type = "success";
            swal(data.success, data.successCallback);
          }
        });
      }
    };

    var listJsonUrl = $attrs.listjsonurl;

    $http.get(listJsonUrl)
      .then(function (result) {
        if (result.data.code === 'ok') {
          $scope.items = result.data.items;
        }
      });

    $scope.approveItem = function (item) {
      Helpers.swalWarning({
        options: {
          title: item.projectID ? 'Aprobar proyecto' : 'Aprobar organización',
          text: item.projectID ? "¿Seguro que quieres aprobar este proyecto?" :
            "¿Estás seguro de que quieres aprobar esta organización?",
            confirmButtonText: "Si",
            cancelButtonText: "Cancelar"
        },
        post: {
          approveItem: true,
          id: item.id
        },
        success: {
          title: item.projectID ? "Proyecto aprobado" : "Organización aprobada",
          text: item.projectID ? "El proyecto ha sido aprobado" : "La organización ha sido aprobada"
        },
        successCallback: function () {
          $scope.items = $scope.items.filter(function (_item) {
            return _item.id !== item.id;
          });
          $scope.$digest();
        }
      });
    };

    $scope.rejectItem = function (item) {
      Helpers.swalWarning({
        options: {
          title: item.projectID ? 'Eliminar proyecto' : 'Eliminar organización',
          text: item.projectID ? "¿Estás seguro de que quieres eliminar este proyecto?\n" :
            "¿Estás seguro de que quieres eliminar esta organización?",
            confirmButtonText: "Si",
            cancelButtonText: "Cancelar"
        },
        post: {
          rejectItem: true,
          id: item.id
        },
        success: {
          title: item.projectID ? "Proyecto eliminado" : "Organización eliminada",
          text: item.projectID ? "El proyecto ha sido eliminado" : "La organización ha sido eliminada"
        },
        successCallback: function () {
          $scope.items = $scope.items.filter(function (_item) {
            return _item.id !== item.id;
          });
          $scope.$digest();
        }
      });
    };

    $scope.selectAll = function () {
      $scope.items = $scope.items.map(function (item) {
        item.checked = true;
        return item;
      });
    };

    $scope.deselectAll = function () {
      $scope.items = $scope.items.map(function (item) {
        item.checked = false;
        return item;
      });
    };
  });