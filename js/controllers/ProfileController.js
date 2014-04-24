application.controller('ProfileController', ['$scope', 'UserService', function ($scope, UserService) {
    // Controller variables
    $scope.user = {};

    // Get current user
    UserService.current()
        .success(function (data, status, headers, config) {
            $scope.user = data;
        });
}]);