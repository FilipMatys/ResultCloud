/**
    DifferenceOverviewController.js
 */
application.controller('DifferenceOverviewController', ['$scope', '$stateParams', 'SubmissionService', function ($scope, $stateParams, SubmissionService) {
    var data = {
        Project: $stateParams.projectId,
        Submissions: $stateParams.differenceArray
    };

    $scope.DifferenceOverview = {};

    $scope.$parent.PendingChanges = true;
    SubmissionService.difference(data)
        .success(function (data, status, headers, config) {
            $scope.DifferenceOverview = data.Data;
            $scope.$parent.PendingChanges = false;
        });
}]);