application.directive('corlyDifferenceList', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/components/difference/list.html',
        controller: function ($scope, $stateParams, SubmissionService) {
            $scope.HideCategory = [];

            var data = {
                Project: $stateParams.projectId,
                Submissions: $stateParams.differenceArray,
                Type: "LIST",
                Meta: null
            };

            $scope.DifferenceOverview = {};

            $scope.PendingChanges = true;
            SubmissionService.difference(data)
                .success(function (data, status, headers, config) {
                    $scope.DiffData = data.Data;
                    $scope.PendingChanges = false;
                });
        }
    }
});