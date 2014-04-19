/**
    SubmissionOverviewController.js
 */
application.controller('SubmissionOverviewController', ['$scope', '$stateParams', 'SubmissionService', function ($scope, $stateParams, SubmissionService) {
    $scope.SubmissionOverview = {};

    SubmissionService.get($stateParams.submissionId)
        .success(function (data, status, headers, config) {
            $scope.SubmissionOverview = data.Data;
        });

}]);