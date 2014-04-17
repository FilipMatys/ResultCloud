/**
    ProjectOverviewController.js
 */
application.controller('ProjectOverviewController', ['$scope', '$stateParams', 'ProjectService', function ($scope, $stateParams, ProjectService) {
    $scope.Project = {};

    // Load project data
    ProjectService.get($stateParams.projectId);
}]);