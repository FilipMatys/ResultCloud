application.controller('ProfileSettingsController', ['$scope', '$http', 'ProfileService', function($scope, $http, ProfileService) {
        $scope.user = {};

        /* Get user detail */
        ProfileService.get()
                .success(function(data, status, headers, config) {
                    $scope.user = data.result;
                    ShowStatusMessage(ENUM_Status.INFORMATION, 'Resources loaded');
                })
                .error(function(data, status, headers, config) {
                    ShowStatusMessage(ENUM_Status.ERROR, "Failed to load resources");
                });

        /* Save user */
        $scope.Save = function() {
            ProfileService.save($scope.user)
                    .success(function(data, status, headers, config) {
                        if (data.result.IsValid)    {
                            ShowStatusMessage(ENUM_Status.SUCCESS, 'Profile was successfuly modified');
                            $scope.user = data.result.Data;
                        }
                        else {
                            ShowStatusMessage(ENUM_Status.ERROR, 'Modifying profile failed');
                        }
                    })
                    .error(function(data, status, headers, config) {
                        ShowStatusMessage(ENUM_Status.ERROR, "Failed to contact server");
                    });
        };

    }]);