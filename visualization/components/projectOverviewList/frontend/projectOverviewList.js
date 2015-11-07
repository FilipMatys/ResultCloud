application.directive('projectOverviewList', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/components/projectOverviewList/frontend/template.html',
        controller: function ($scope, $state, $stateParams, ProjectService, ViewService) {
            $scope.PendingChanges = false;
            $scope.projectId = $stateParams.projectId;

            // Load data
            var LoadSubmissions = function () {
                // Get data for current view
                ViewService.visualize({
                    Source: {
                        Id: $stateParams.projectId   
                    },
                    Identifier: 'project-overview-list'
                })
                .success(function (data, status, headers, config) {
                    $scope.ListData = data.Data;
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