application.directive('corlyComponentSettingsLoader', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/loaders/templates/settings.html',
        controller: function ($scope, $stateParams, TemplateSettingsService) {
		// Load views for current submission
            TemplateSettingsService.get({
		Id: $stateParams.projectId
            })
                .success(function (data, status, headers, config) {
                    $scope.templates = data;
                });

            $scope.Save =  function()   {
                    TemplateSettingsService.save($scope.templates)
                    .success(function (data, status, headers, config) {
                        // Show status
                        $scope.ShowStatus('Save settings', data.IsValid, data.Errors);
                    });
            }
        }
    }
});