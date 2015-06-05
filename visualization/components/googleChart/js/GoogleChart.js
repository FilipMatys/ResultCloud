application.directive('corlyGoogleChart', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/components/googleChart/chart.html',
        controller: function ($scope, $stateParams, ProjectService, SubmissionService) {
            //  Initalize request
            $scope.Request = {
                ItemId: 0,
                Type: "GOOGLE_CHART"
            }

            // Load chart
            $scope.LoadChart = function () {
                // Load data based on project/submission
                // First check, if state of submission is set
                if ($stateParams.submissionId) {
                    // Set request id
                    $scope.Request.ItemId = $stateParams.submissionId;

                    // Load data
                    SubmissionService.get($scope.Request)
                        .success(function (data, status, headers, config) {
                            $scope.Data = data.Data;
                        });

                }
                    // Second, check if difference list is set
                else if ($stateParams.differenceArray) {
                    // Load data
                    SubmissionService.difference({
                        Project: $stateParams.projectId,
                        Submissions: $stateParams.differenceArray,
                        Type: "GOOGLE_CHART",
                        Meta: null
                    })
                        .success(function (data, status, headers, config) {
                            $scope.Data = data.Data;
                        });
                }
                    // Third, check if project is set
                else if ($stateParams.projectId) {
                    // Set project id
                    $scope.Request.ItemId = $stateParams.projectId;

                    // Load data
                    ProjectService.get($scope.Request)
                        .success(function (data, status, headers, config) {
                            $scope.Data = data.Data;
                        });
                }
            }

            // Load chart
            $scope.LoadChart();

            // Check for data change
            $scope.$on("data-change", function () {
                $scope.LoadChart();
            });
        }
    }
});