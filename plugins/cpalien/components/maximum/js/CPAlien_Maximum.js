application.directive('cpalienMaximum', function () {
    return {
        restrict: 'E',
        templateUrl: 'plugins/cpalien/components/maximum/template.html',
        controller: function ($scope, $stateParams, SubmissionService) {
            // Load data
            SubmissionService.get({
                ItemId: $stateParams.submissionId,
                Type: "MAXIMUM"
            })
                .success(function (data, status, headers, config) {
                    $scope.maximum = data.Data;
                });
        }
    }
});