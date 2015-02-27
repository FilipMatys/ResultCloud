application.directive('corlyTestCaseList', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/components/testCaseList/template.html',
        controller: function ($scope, $stateParams, SubmissionService) {
            $scope.ShowColumn = [];
            $scope.HideCategory = [];
            $scope.Page = 1;
            $scope.Pages = 0;
            $scope.PendingChanges = false;

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
                $scope.PendingChanges = true;
                SubmissionService.get({
                    ItemId: $stateParams.submissionId,
                    Type: "LIST",
                    Meta: $scope.ListData ? $scope.ListData.Page : 1
                })
                .success(function (data, status, headers, config) {
                    $scope.ListData = data.Data;
                    $scope.PendingChanges = false;
                    $scope.Page = $scope.ListData.Page ? $scope.ListData.Page : 1;
                    $scope.Pages = Math.ceil($scope.ListData.ItemsCount / $scope.ListData.PageSize);
                });
            }

            $scope.FetchData();
        }
    }
});