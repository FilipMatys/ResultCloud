var application = angular.module('IBP', [
    'ui.router',
    'angularFileUpload'
]);

application.config(function ($stateProvider, $urlRouterProvider)   {
    
    $urlRouterProvider.otherwise('/login');
    
    $stateProvider
    .state('home', {
        url: '/home',
        abstract: true,
        templateUrl: './home.html',
        controller: 'HomeController'
    })
    .state('home.dashboard', {
        url: '',
        templateUrl: './views/dashboard.html',
        controller: 'DashboardController'
    })
    .state('home.profileSettings', {
        url: '/profile/settings',
        templateUrl: './views/profile/settings.html',
        controller: 'ProfileSettingsController'
    })
    .state('home.import', {
        url: '/import',
        templateUrl: './views/import.html',
        controller: 'ImportController'
    })
    .state('login', {
        url: '/login',
        templateUrl: './login.html',
        controller: 'LoginController'
    });
});