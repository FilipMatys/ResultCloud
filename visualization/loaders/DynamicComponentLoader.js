application.directive('corlyDynamicComponentLoader', function ($compile) {
    return {
        restrict: 'E',
        scope: {
            view: '=view'
        },
        controller: function ($scope, $element, $stateParams, ViewService) {

            // Load views for current project
            ViewService.views({
                Project: {
                    Id: $stateParams.projectId
                },
                View: $scope.view
            })
                .success(function (data, status, headers, config) {
                    // Compile each component...
                    angular.forEach(data.Data, function (component) {
                        var el = $compile('<' + component.Identifier + '/>')($scope);
                        // And append to html
                        $element.parent().append(el);
                    });
                });
        }
    }
});