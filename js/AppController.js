var application = angular.module('IBP', [
    'ui.router'
]);

application.config(function ($stateProvider, $urlRouterProvider)   {
    
    $urlRouterProvider.otherwise('/login');
    
    $stateProvider
    .state('home', {
        url: '/home',
        templateUrl: './home.html',
        controller: 'HomeController'
    })
    .state('home.profileSettings', {
        url: '/profile/settings',
        templateUrl: './views/profile/settings.html',
        controller: 'ProfileSettingsController'
    })
    .state('login', {
        url: '/login',
        templateUrl: './login.html',
        controller: 'LoginController'
    });
});