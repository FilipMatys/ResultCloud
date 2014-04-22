application.directive('corlyDynamicProjectComponentLoader', function ($compile) {
    return {
        restrict: 'E',
        controller: function ($scope, $element, $stateParams, ProjectService) {

            // Load views for current project
            ProjectService.views($stateParams.projectId)
                .success(function (data, status, headers, config) {
                    // Compile each component...
                    angular.forEach(data.Data, function (component) {
                        var el = $compile(component)($scope);
                        // And append to html
                        $element.parent().append(el);
                    });
                });
        }
    }
});