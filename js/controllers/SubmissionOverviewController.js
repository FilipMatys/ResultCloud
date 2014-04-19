/**
    SubmissionOverviewController.js
 */
application.controller('SubmissionOverviewController', ['$scope', '$stateParams', 'SubmissionService', function ($scope, $stateParams, SubmissionService) {
    $scope.SubmissionOverview = {};

    $scope.$parent.PendingChanges = true;
    SubmissionService.get($stateParams.submissionId)
        .success(function (data, status, headers, config) {
            $scope.SubmissionOverview = data.Data;
            $scope.$parent.PendingChanges = false;
        });

}]);