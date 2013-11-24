var application = angular.module('IBP', [
    'ui.router'
]);

application.config(function ($stateProvider, $urlRouterProvider)   {
    
    $urlRouterProvider.otherwise('/login');
    
    $stateProvider
    .state('home', {
        url: '/home',
        templateUrl: './home.html'
    })
    .state('home.profileSettings', {
        url: '/profile/settings',
        templateUrl: './views/profile/settings.html'
    })
    .state('login', {
        url: '/login',
        templateUrl: './login.html'
    });
})
application.controller('ApplicationController', ['$scope', '$http', function ($scope, $http) {
    $scope.Login = function () {
    };

    $scope.Logout = function () {
    };
}])
application.controller('HomeController', ['$scope', '$http', function ($scope, $http) {    
    
}]);