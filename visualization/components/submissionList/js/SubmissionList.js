application.directive('corlySubmissionList', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/components/submissionList/list.html',
        controller: function ($scope, $state, $stateParams, ProjectService) {
            $scope.PendingChanges = false;
            $scope.projectId = $stateParams.projectId;

            // Load data
            var LoadSubmissions = function () {
                // Initialize request object
                $scope.Request = {
                    ItemId: $stateParams.projectId,
                    Type: "LIST"
                }
                $scope.PendingChanges = true;
                ProjectService.get($scope.Request)
                .success(function (data, status, headers, config) {
                    $scope.ListData = data.Data;
                    $scope.PendingChanges = false;
                });
            }
            LoadSubmissions();
            
            // Compare all selected submissions
            $scope.Differ = function () {
                // Get all submissions market for difference
                var submissions = [];
                angular.forEach($scope.ListData.Submissions, function (item) {
                    if (item.Submission.Differ)
                        submissions.push(item.Submission.Id);
                });

                // Check if there is anything to compare
                if (submissions.length < 2)
                    return;

                // Go to differ page
                $state.go('home.difference-overview', { projectId: $stateParams.projectId, differenceArray: submissions.join("&") });
            }
            var listAllProperties = function (o){     
                var objectToInspect;     
                var result = [];
                
                for(objectToInspect = o; objectToInspect !== null; objectToInspect = Object.getPrototypeOf(objectToInspect)){  
                    result = result.concat(Object.getOwnPropertyNames(objectToInspect));  
                }
                
                return result; 
            }

            // Delete submission
            $scope.DeleteSubmission = function (sid, pid) {
                if (confirm("Are you sure?")) {
                    Ids = {
                        submissionId: sid.submissionId,
                        projectId: pid.projectId
                    };
                   ProjectService.submissionDelete(Ids)
                        .success(function (data, status, headers, config) {
                            // Load new data
                            LoadSubmissions();
                            // Broadcast data change
                            $scope.$root.$broadcast("data-change");
                            // Show status
                            $scope.$parent.ShowStatus('Delete submission', data.IsValid, data.Errors);
                        });
                }
            };

            // Watch for "select all" change
            $scope.$watch('SelectAll', function (value) {
                if (!$scope.ListData)
                    return;

                angular.forEach($scope.ListData.Submissions, function (item) {
                    item.Submission.Differ = value;
                });
            });
        }
    }
});