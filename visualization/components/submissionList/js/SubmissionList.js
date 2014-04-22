application.directive('corlySubmissionList', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/components/submissionList/list.html',
        controller: function ($scope, $state, $stateParams, ProjectService) {
            // Initialize request object
            $scope.Request = {
                ItemId: $stateParams.projectId,
                Type: "LIST"
            }

            // Load data
            ProjectService.get($scope.Request)
                .success(function (data, status, headers, config) {
                    $scope.Data = data.Data;
                });

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
                if (!$scope.Data)
                    return;

                angular.forEach($scope.Data.Submissions, function (item) {
                    item.Submission.Differ = value;
                });
            });
        }
    }
});