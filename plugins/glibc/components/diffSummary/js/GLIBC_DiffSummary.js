application.directive('glibcDiffSummary', function () {
    return {
        restrict: 'E',
        templateUrl: 'plugins/glibc/components/diffSummary/template.html',
        controller: function ($scope, $stateParams, SubmissionService) {

            // Load data
            SubmissionService.difference({
                Project: $stateParams.projectId,
                Submissions: $stateParams.differenceArray,
                Type: "DIFF_SUMMARY",
                Meta: null
            })
                .success(function (data, status, headers, config) {
                    $scope.diffSummary = data.Data;
                });
        }
    }
});