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

            $scope.toggleHeader = function (index, cells) {
                if (index == 0)
                    return;

                var i = 0;
                angular.forEach(cells, function (item) {
                    if (i == index)
                        item.Active = true;
                    else
                        item.Active = false;

                    i++;
                });
            };
        }
    }
});