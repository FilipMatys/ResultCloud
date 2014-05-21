application.directive('systemtapDiffConfigurationView', function () {
    return {
        restrict: 'E',
        templateUrl: 'plugins/systemtap/components/diffConfiguration/template.html',
        controller: function ($scope, $stateParams, SubmissionService) {
            // Load data
            SubmissionService.difference({
                Project: $stateParams.projectId,
                Submissions: $stateParams.differenceArray,
                Type: "DIFF_CONFIGURATION",
                Meta: null
            })
                .success(function (data, status, headers, config) {
                    $scope.diffConfiguration = data.Data;
                });
        }
    }
});