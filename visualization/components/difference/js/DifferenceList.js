application.directive('corlyDifferenceList', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/components/difference/list.html',
        controller: function ($scope, $stateParams, SubmissionService) {
            $scope.HideCategory = [];

            $scope.DifferenceOverview = {};

            $scope.FetchData = function () {
                $scope.PendingChanges = true;
                SubmissionService.difference({
                    Project: $stateParams.projectId,
                    Submissions: $stateParams.differenceArray,
                    Type: "LIST",
                    Meta: $scope.DiffData ? $scope.DiffData.Page : 1
                })
                    .success(function (data, status, headers, config) {
                        $scope.DiffData = data.Data;
                        $scope.PendingChanges = false;
                        $scope.Pagination = data.Data[0].Pagination;
                        $scope.DiffData.Page = data.Data[0].Page;
                        $scope.Pages = Math.ceil(data.Data[0].ItemsCount / 30);
                    });
            }

            $scope.FetchData();
        }
    }
});