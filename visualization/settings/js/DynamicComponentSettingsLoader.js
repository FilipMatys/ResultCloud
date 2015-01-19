application.directive('corlyComponentSettingsLoader', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/settings/list.html',
        controller: function ($scope, $stateParams, TemplateSettingsService) {
        	// Load views for current submission
            TemplateSettingsService.get({
            	Id: $stateParams.projectId
            })
                .success(function (data, status, headers, config) {
                    $scope.templates = data;
                });
        }
    }
});