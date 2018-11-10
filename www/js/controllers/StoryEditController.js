angular
    .module(angularAppName)
    .controller('StoryEditController', function ($scope, $http, $timeout, $attrs, Upload) {
        var storyID = $attrs.storyid;

        // featuredImage
        (function () {
            $scope.featuredImageUpload = {};
            $scope.uploadFeaturedImage = function (file, errFiles) {
                $scope.featuredImageUpload.f = file;
                $scope.featuredImageUpload.errFile = errFiles && errFiles[0];
                if (file) {
                    file.upload = Upload.upload({
                        url: SITE_RELATIVE_PATH + '/temp-gallery.json',
                        data: {file: file}
                    });

                    file.upload.then(function (response) {
                        file.result = response.data;
                        if (response.data.code == 'ok')
                            $scope.story.featuredImage = response.data.imgPath;
                        else if (response.data.code == 'error')
                            $scope.featuredImageUpload.errorMsg = response.data.errors;

                        $scope.featuredImageUpload = {};
                    }, function (response) {
                        if (response.status > 0)
                            $scope.featuredImageUpload.errorMsg = response.status + ': ' + response.data;
                    }, function (evt) {
                        file.progress = Math.min(100, parseInt(100.0 *
                            evt.loaded / evt.total));
                    });
                }
            };
        }());

        // mainImage
        (function () {
            $scope.mainImageUpload = {};
            $scope.uploadMainImage = function (file, errFiles) {
                $scope.mainImageUpload.f = file;
                $scope.mainImageUpload.errFile = errFiles && errFiles[0];
                if (file) {
                    file.upload = Upload.upload({
                        url: SITE_RELATIVE_PATH + '/temp-gallery.json',
                        data: {file: file}
                    });

                    file.upload.then(function (response) {
                        file.result = response.data;
                        if (response.data.code == 'ok')
                            $scope.story.mainImage = response.data.imgPath;
                        else if (response.data.code == 'error')
                            $scope.mainImageUpload.errorMsg = response.data.errors;

                        $scope.mainImageUpload = {};
                    }, function (response) {
                        if (response.status > 0)
                            $scope.mainImageUpload.errorMsg = response.status + ': ' + response.data;
                    }, function (evt) {
                        file.progress = Math.min(100, parseInt(100.0 *
                            evt.loaded / evt.total));
                    });
                }
            };
        }());

        // saveStory
        (function () {
            $scope.saveStory = function () {
                $scope.errors = {};
                $scope.loading = true;

                var data = $scope.story;
                data.save = true;
                data.content = tinyMCE.get('newStory').getContent();

                $timeout(function () {
                    $http.post(SITE_RELATIVE_PATH + '/story/edit/' + storyID + '.json', data)
                        .then(function (response) {
                            $scope.loading = false;
                            if (response.data.code == 'ok') {
                                swal('Exito', 'Los cambios se han guardado con éxito', "success");
                            } else if (response.data.code == 'error') {
                                $scope.errors = response.data.errors;
                                console.log({errors: response.data.errors});
                            } else {
                                alert('unexpected error');
                                console.log(response.data);
                            }
                        });
                }, 500);
            }
        }());

        // Get story details
        (function () {
            $scope.story = {};
            $http.get(SITE_RELATIVE_PATH + '/story/edit/' + storyID + '.json')
                .then(function (response) {
                    $scope.story = response.data;
                    $("#datePublished").datepicker("setDate", $scope.story.datePublished);
                })
        }());
    });