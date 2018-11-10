(function () {
    angular
        .module(angularAppName)
        .controller('ProjectEditController', function ($scope, $http, $timeout, Upload, $attrs) {
            var projectID = $attrs.projectid;
            var projectURL = $attrs.projecturl;

            var editCountry = $('#edit-country');
            var editCountryRegion = $('#edit-countryRegion');

            $scope.logo = new DSI_Helpers.UploadImageHandler(Upload);
            $scope.headerImage = new DSI_Helpers.UploadImageHandler(Upload);


            $scope.project = {};
            $http.get(SITE_RELATIVE_PATH + '/project/edit/' + projectID + '.json')
                .then(function (result) {
                    $scope.project = result.data || {};
                    $scope.logo.image = $scope.project.logo;
                    $scope.headerImage.image = $scope.project.headerImage;
                });

            $scope.currentTab = 'step1';
            $scope.submitStep1 = function (params) {
                $scope.project.tags = $('#tagsSelect').val();
                $scope.project.networkTags = $('#networkTagsSelect').val();
                $scope.project.areasOfImpact = getAreaOfImpactTags();
                $scope.project.focusTags = getSelectedFocusTags();
                $scope.project.impactTagsC = $('#impact-tags-c').val();
                $scope.project.organisations = $('#organisationsSelect').val();
                $scope.saveDetails({
                    postField: 'step1',
                    onSuccess: function () {
                        if (params && params.proceed == false) {
                            swal('Exito!', 'Los cambios se han guardado con éxito.', 'success');
                        } else {
                            $scope.currentTab = 'step2';
                        }
                    }
                });

                function getSelectedFocusTags() {
                    var focusTags = [];
                    $('input[name="focusTags[]"]:checked').each(function (i) {
                        focusTags[i] = $(this).val();
                    });
                    return focusTags;
                }

                function getAreaOfImpactTags() {
                    var selectedTags = $('#impact-tags-a').val() || [];
                    $('input[name="impactTags[]"]:checked').each(function (i) {
                        selectedTags.push($(this).val());
                    });
                    return selectedTags;
                }
            };

            $scope.submitStep2 = function (params) {
                $scope.project.countryID = editCountry.val();
                $scope.project.region = editCountryRegion.val();
                $scope.saveDetails({
                    postField: 'step2',
                    onSuccess: function () {
                        if (params && params.proceed == false) {
                            swal('Exito!', 'Los cambios se han guardado con éxito.', 'success');
                        } else {
                            $scope.currentTab = 'step3';
                        }
                    }
                })
            };
            $scope.submitStep3 = function (params) {
                $scope.project.description = tinyMCE.get('description').getContent();
                $scope.project.socialImpact = tinyMCE.get('socialImpact').getContent();
                $scope.saveDetails({
                    postField: 'step3',
                    onSuccess: function () {
                        if (params && params.proceed == false) {
                            swal('Exito!', 'Los cambios se han guardado con éxito.', 'success');
                        } else {
                            $scope.currentTab = 'step4';
                        }
                    }
                })
            };
            $scope.submitStep4 = function () {
                $scope.errors = {};
                if (!$scope.project.confirm) {
                    $scope.errors = {
                        confirm: 'Tienes que estar de acuerdo con nuestros términos y condiciones.\n'
                    };
                } else {
                    $scope.project.logo = $scope.logo.image;
                    $scope.project.headerImage = $scope.headerImage.image;
                    $scope.saveDetails({
                        postField: 'step4',
                        onSuccess: function () {
                            swal({
                                title: "Exito!",
                                text: "Los detalles del proyecto se han guardado con éxito.",
                                type: "success"
                            }, function (isConfirm) {
                                window.location.href = projectURL;
                            });
                        }
                    })
                }
            };

            $scope.saveDetails = function (options) {
                $scope.loading = true;
                $scope.errors = {};

                var data = $scope.project;
                data['saveDetails'] = true;
                data['step'] = options.postField;

                console.log(data);

                $http.post(SITE_RELATIVE_PATH + '/project/edit/' + projectID + '.json', data)
                    .then(function (response) {
                        console.log(response.data);
                        $scope.loading = false;

                        if (response.data.code == 'ok')
                            options.onSuccess();
                        else if (response.data.code == 'error')
                            $scope.errors = response.data.errors;
                    });
            };

            // country & region
            var currentCountry = '';
            var listCountries = function () {
                $http.get(SITE_RELATIVE_PATH + '/countries.json')
                    .then(function (result) {
                        editCountry.select2({data: result.data});
                        editCountry.on("change", function () {
                            if (currentCountry != editCountry.val()) {
                                listCountryRegions(editCountry.val());
                                currentCountry = editCountry.val();
                            }
                        });
                        $scope.$watch('organisation.countryID', function (param) {
                            editCountry.val($scope.project.countryID).trigger("change")
                        });
                    });
            };
            var listCountryRegions = function (countryID) {
                countryID = parseInt(countryID) || 0;
                if (countryID > 0) {
                    $scope.regionsLoaded = false;
                    $scope.regionsLoading = true;
                    $http.get(SITE_RELATIVE_PATH + '/countryRegions/' + countryID + '.json')
                        .then(function (result) {
                            editCountryRegion
                                .html("")
                                .select2({data: result.data});
                            $scope.regionsLoaded = true;
                            $scope.regionsLoading = false;
                            editCountryRegion.val($scope.project.region).trigger("change");
                        });
                }
            };
            listCountries();
        });

    tinymce.init({
        selector: '.editableTextarea',
        statusbar: false,
        height: 500,
        plugins: "autoresize autolink lists link preview paste textcolor colorpicker image imagetools media",
        autoresize_bottom_margin: 0,
        autoresize_max_height: 500,
        menubar: false,
        toolbar1: 'styleselect | forecolor backcolor | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | link image media | preview',
        image_advtab: true,
        paste_data_images: false
    });

}());