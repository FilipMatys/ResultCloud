application.directive('rcGoogleChart', function () {
    return {
        restrict: 'E',
        scope: {
            Data: '=data'    
        },
        templateUrl: 'visualization/tools/googleChart/chart.html',
        controller: function ($scope, $stateParams, ProjectService, SubmissionService) {
        }
    }
});