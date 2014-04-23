application.directive('corlyDynamicSubmissionComponentLoader', function ($compile) {
    return {
        restrict: 'E',
        controller: function ($scope, $element, $stateParams, SubmissionService) {

            // Load views for current submission
            SubmissionService.views($stateParams.submissionId)
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