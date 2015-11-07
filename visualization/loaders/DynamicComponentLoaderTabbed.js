application.directive('corlyDynamicComponentLoaderTabbed', function ($compile) {
    return {
        restrict: 'E',
        scope: {
            view: '=view',
        },
        templateUrl: 'visualization/loaders/templates/tabbed.html',
        controller: function ($scope, $element, $stateParams, ViewService) {
            $scope.components = [];

            // Load views for current project
            ViewService.views({
                Project: {
                    Id: $stateParams.projectId
                },
                View: $scope.view
            })
                .success(function (data, status, headers, config) {
                    $scope.components = data.Data;
                    
                    // Set all components to be hidden
                    angular.forEach($scope.components, function(component)  {
                       component.active = false; 
                    });
                    
                    // Show first component
                    $scope.components[0].active = true;
                });
        }
    }
});

application.directive('rcComponentCompiler', function ($compile)    {
    return {
        restrict: 'E',
        scope: {
            component: '=component'
        },
        controller: function ($scope, $element) {
            // Compile component
            var el = $compile('<' + $scope.component + '/>')($scope);
            // Append to parent tab item
            $element.parent().append(el);
        } 
    }      
});