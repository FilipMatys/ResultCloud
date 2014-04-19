/**
    ProjectOverviewController.js
 */
application.controller('ProjectOverviewController', ['$scope', '$stateParams', 'ProjectService', function ($scope, $stateParams, ProjectService) {
    $scope.ProjectOverview = {};

    // Load project data
    $scope.$parent.PendingChanges = true;
    ProjectService.get($stateParams.projectId)
        .success(function (data, status, headers, config) {
            $scope.ProjectOverview = data.Data;
            $scope.$parent.PendingChanges = false;
        });
}]);