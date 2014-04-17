var application = angular.module('CorlyWMT', [
		'ui.router',
        'angularFileUpload',
        'googlechart'
	]);

// Load foundation on every new page load
application.run(function($rootScope, $timeout)	{
	$rootScope.$on('$viewContentLoaded', function()	{
		$timeout(function()	{
			$(document).foundation();
		}, 500);
	})
});

/**
 * Configuration for routes
 */
application.config(function($stateProvider, $urlRouterProvider){

	// Set default page to login
	$urlRouterProvider.otherwise('/');

	// Define states
	$stateProvider

	// Login page
	.state('login', {
	    url: '/',
	    templateUrl: './views/login/index.html',
	    controller: 'LoginController'
	})
	// Home page
	.state('home', {
	    url: '/home',
	    abstract: true,
	    templateUrl: './views/home/index.html',
	    controller: 'HomeController'
	})
	// Dashboard
	.state('home.dashboard', {
	    url: '',
	    templateUrl: './views/home/dashboard.html',
	    controller: 'DashboardController'
	})
    // Import
	.state('home.import', {
	    url: '/import',
	    templateUrl: './views/home/import.html',
	    controller: 'ImportController'
	})
    // Settings
	.state('home.settings', {
	    url: '/settings',
	    templateUrl: './views/home/settings.html',
	    controller: 'SettingsController'
	})
    // Plugin management
	.state('home.plugin-management', {
	    url: '/plugin-management',
	    templateUrl: './views/home/pluginManagement.html',
	    controller: 'PluginManagementController'
	})
    // Data overview
	.state('home.data-overview', {
	    url: '/data-overview',
	    templateUrl: './views/home/dataOverview.html',
	    controller: 'DataOverviewController'
	})
    // Plugin detail
    .state('home.plugin', {
        url: '/plugin-management/{pluginId}',
        templateUrl: './views/home/plugin.html',
        controller: 'PluginController'
    })
    // Plugin overview detail
    .state('home.plugin-overview', {
        url: '/plugin-overview/{pluginId}',
        templateUrl: './views/home/overview/plugin.html',
        controller: 'PluginOverviewController'
    })
    // Project overview detail
    .state('home.project-overview', {
        url: '/project-overview/{projectId}',
        templateUrl: './views/home/overview/project.html',
        controller: 'ProjectOverviewController'
    })
    // Profile
	.state('home.profile', {
	    url: '/profile',
	    templateUrl: './views/home/profile.html',
	    controller: 'ProfileController'
	});
});

