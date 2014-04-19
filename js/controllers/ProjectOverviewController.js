/**
    ProjectOverviewController.js
 */
application.controller('ProjectOverviewController', ['$scope', '$stateParams', 'ProjectService', function ($scope, $stateParams, ProjectService) {
    $scope.ProjectOverview = {};

    // Load project data
    ProjectService.get($stateParams.projectId)
        .success(function (data, status, headers, config) {
            $scope.ProjectOverview = data.Data;
        });
}]);