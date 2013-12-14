application.controller('HomeController', ['$scope', '$http', function ($scope, $http) {    
        $scope.test = function()    {
            console.log('Executing tests...');
            ShowStatusMessage(ENUM_Status.SUCCESS, 'Test suite was imported');
        };
}]);