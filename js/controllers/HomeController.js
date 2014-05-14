application.controller('HomeController', ['$scope', '$state', 'AuthentizationService', 'UserService', function ($scope, $state, AuthentizationService, UserService) {
    // Init variables
    $scope.user = {};

    // Logout
    $scope.Logout = function () {
        // Deauthorize user
        AuthentizationService.deauthorize()
            .success(function (data, status, headers, config) {
                $scope.user = {};
                $state.go('login');
            });
    }

    // Get current user
    UserService.current()
        .success(function (data, status, headers, config) {
            $scope.user = data;
        });
}])