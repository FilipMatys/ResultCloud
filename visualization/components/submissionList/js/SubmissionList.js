application.directive('corlySubmissionList', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/components/submissionList/list.html',
        scope:  {
            Data: '=data'
        },
        controller: function ($scope, $state, $stateParams) {

            // Compare all selected submissions
            $scope.Differ = function () {
                // Get all submissions market for difference
                var submissions = [];
                angular.forEach($scope.Data.Submissions, function (item) {
                    if (item.Submission.Differ)
                        submissions.push(item.Submission.Id);
                });

                // Check if there is anything to compare
                if (submissions.length < 2)
                    return;

                // Go to differ page
                $state.go('home.difference-overview', { projectId: $stateParams.projectId, differenceArray: submissions.join("&") });
            }

            // Watch for "select all" change
            $scope.$watch('SelectAll', function (value) {
                angular.forEach($scope.Data.Submissions, function (item) {
                    item.Submission.Differ = value;
                });
            });
        }
    }
});