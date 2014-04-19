application.directive('corlyTestCaseList', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/components/testCaseList/list.html',
        scope: {
            Data: '=data'
        },
        controller: function ($scope) {

        }
    }
});