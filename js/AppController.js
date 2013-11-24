angular.module('IBP', [])
.controller('AppCtrl', ['$scope', '$http', function ($scope, $http) {
    $scope.page = 'login.html';
    $scope.user = {};

    $scope.Login = function () {
        $http({
            method: 'POST',
            url: './api/LoginController.php?method=authorize',
            data: $scope.user
        })
          .success(function (data, status, headers, config) {
              if (data.result) {
                  $scope.page = 'home.html';
                  $scope.view = 'dashboard.html';
              }
          })
          .error(function (data, status, headers, config) {
              $scope.result = 'Error';
          });
          
          $scope.user = {};
    }

    $scope.Logout = function () {
        $http({
            method: 'POST',
            url: './api/LoginController.php?method=deauthorize'
        })
         .success(function (data, status, headers, config) {
             if (data.result) {
                $scope.page = 'login.html';
             }
         })
         .error(function (data, status, headers, config) {
         });
    }
}])
.controller('HomeCtrl', ['$scope', '$http', function ($scope, $http) {

}]);