/**
    UsersController.js
 */
application.controller('UsersController', ['$scope', 'UserService', function ($scope, UserService) {
    $scope.Users = [];

    UserService.query()
        .success(function (data, status, headers, config) {
            $scope.Users = data;
        });
}]);