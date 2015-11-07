application.directive('rcSubmissionOverviewList', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/tools/submissionOverviewList/template.html',
        controller: function ($scope, $stateParams, SubmissionService, ViewService) {
            $scope.ShowColumn = [];
            $scope.HideCategory = [];
            $scope.Page = 1;
            $scope.Pages = 0;

            // Generate range
            $scope.Range = function(from, to)   {
                var range = [];
                // Generate range
                for (var i = from; i <=  to; i++) {
                    range.push(i);
                };

                // Return result
                return range;
            }

            $scope.$watch('ListData', function (value) {
                if (!value || !value.ViewTypes)
                    return;

                $scope.View = value.ViewTypes[0];
            }, false);

            // Change page and load data
            $scope.ChangePage = function(page)  {
                // Do not load the same page as actual
                if (page == $scope.Page)
                    return;

                // Change page and get data
                $scope.ListData.Page = page;
                $scope.FetchData();
            }
            
            
            // Load data
            $scope.FetchData = function () {
                ViewService.visualize({
                    Source: {
                        Id: $stateParams.submissionId   
                    },
                    Identifier: 'submission-overview-list-dejagnu',
                    Metadata: {
                        Pagination: $scope.ListData ? $scope.ListData.Page : 1
                    }
                })
                .success(function (data, status, headers, config) {
                    $scope.ListData = data.Data;
                    $scope.Page = $scope.ListData.Page ? $scope.ListData.Page : 1;
                    $scope.Pages = Math.ceil($scope.ListData.ItemsCount / $scope.ListData.PageSize);
                });

            }

            $scope.FetchData();
        }
    }
});