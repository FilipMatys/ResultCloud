application.directive('corlyDifferenceList', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/components/difference/list.html',
        scope: {
            Data: '=data'
        },
        controller: function ($scope) {
        }
    }
});