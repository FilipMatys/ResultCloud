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

            $scope.$watch('ListData', function (value) {
                if (!value || !value.ViewTypes)
                    return;

                $scope.View = value.ViewTypes[0];
            }, false);

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
                    $scope.Pages = Math.ceil($scope.ListData.ItemsCount / 100);
                });
            }

            $scope.FetchData();
        }
    }
});