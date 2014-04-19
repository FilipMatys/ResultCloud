application.directive('corlyGoogleChart', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/components/googleChart/chart.html',
        scope: {
            Data: '=data'
        },
        controller: function ($scope) {

        }
    }
});