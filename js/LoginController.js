application.controller('LoginController', ['$scope', '$location','AuthorizationService', function ($scope, $location, AuthorizationService) {
    // Log in user
    $scope.Login = function () {
        AuthorizationService.login($scope.user)
                .success(function(data, status, headers, config) {
                   if (data && data.result)    {
                       $location.path('/home');
                   } 
                })
                .error(function(data, status, headers, config)   {
                    
                });
    };

    $scope.Logout = function () {
    };
}]);