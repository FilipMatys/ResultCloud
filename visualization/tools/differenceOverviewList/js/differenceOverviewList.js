application.directive('rcDifferenceOverviewList', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/tools/differenceOverviewList/template.html',
        controller: function ($scope, $stateParams, ViewService) {
            $scope.HideCategory = [];
            $scope.Page = 0;

            $scope.DifferenceOverview = {};

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

            // Change page and load data
            $scope.ChangePage = function(page)  {
                // Do not load the same page as actual
                if (page == $scope.Page)
                    return;

                // Change page and get data
                $scope.DiffData.Page = page;
                $scope.FetchData();
            }

            $scope.FetchData = function () {
                $scope.PendingChanges = true;
                
                ViewService.visualize({
                    Source: {
                        Submissions: $stateParams.differenceArray   
                    },
                    Identifier: 'difference-overview-list-dejagnu',
                    Metadata: {
                        Pagination: $scope.DiffData ? $scope.DiffData.Page : 1
                    }
                })
                .success(function (data, status, headers, config) {
                    $scope.DiffData = data.Data;
                    $scope.PendingChanges = false;
                    $scope.Pagination = data.Data[0].Pagination;
                    $scope.DiffData.Page = data.Data[0].Page;
                    $scope.Page = $scope.DiffData.Page;
                    $scope.Pages = Math.ceil(data.Data[0].ItemsCount / data.Data[0].PageSize);
                });
            }

            $scope.FetchData();
        }
    }
});