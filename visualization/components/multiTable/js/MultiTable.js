application.directive('corlyMultiTable', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/components/multiTable/template.html',
        scope: {
            view: '=view'
        },
        controller: function ($scope, $stateParams, ViewService) {
            // Get data for current view
            ViewService.visualize({
                Project: {
                    Id: $stateParams.projectId
                },
                View: $scope.view,
                Type: 'MULTITABLE'
            })
                .success(function (data, status, headers, config) {
                    $scope.data = data.Data;
                });
        }
    }
});