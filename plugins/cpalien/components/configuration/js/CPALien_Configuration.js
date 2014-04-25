application.directive('cpalienConfiguration', function () {
    return {
        restrict: 'E',
        templateUrl: 'plugins/cpalien/components/configuration/template.html',
        controller: function ($scope, $stateParams, SubmissionService) {
            // Load data
            SubmissionService.get({
                ItemId: $stateParams.submissionId,
                Type: "CONFIGURATION"
            })
                .success(function (data, status, headers, config) {
                    $scope.configuration = data.Data;
                });
        }
    }
});