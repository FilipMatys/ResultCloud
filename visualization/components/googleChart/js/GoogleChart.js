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
            // Second, check if project is set
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
    }
});