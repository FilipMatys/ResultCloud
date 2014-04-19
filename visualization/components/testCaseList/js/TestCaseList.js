application.directive('corlyTestCaseList', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/components/testCaseList/template.html',
        scope: {
            Data: '=data'
        },
        controller: function ($scope) {
            $scope.ShowColumn = [];

            $scope.$watch('Data', function (value) {
                if (!value)
                    return;

                $scope.View = value.ViewTypes[0];
            }, false);
        }
    }
});