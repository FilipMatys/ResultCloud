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

// Keep track of routing and keep non authorized users away
application.run(['$rootScope', '$location', 'SessionService', function ($rootScope, $location, SessionService) {
    // Array of routes, that dont require login
    var routesThatDontRequireAuth = ['/login'];

    // Wait  for location to change
    $rootScope.$on('$stateChangeStart', function (event, next) {
        // If not login page, check if user is logged
        if (routesThatDontRequireAuth.indexOf($location.path()) < 0)   {
            // Check session
            SessionService.check().success(function (data, status, headers, config) {
                // Check result
                if (data === "false")
                    $location.path('/login');
            });
        }
    });
}]);

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
    // Settings - users
	.state('home.settings-users', {
	    url: '/settings/users',
	    templateUrl: './views/home/settings/users.html',
	    controller: 'UsersController'
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
        url: '/plugin-overview/{pluginId}',
        templateUrl: './views/home/plugin.html',
        controller: 'PluginController'
    })
    // Project overview detail
    .state('home.project-overview', {
        url: '/project-overview/{projectId}',
        templateUrl: './views/home/overview/project.html',
        controller: 'ProjectOverviewController'
    })
    // Project overview detail
    .state('home.project-settings', {
        url: '/project-settings/{projectId}',
        templateUrl: './views/home/projectSettings.html',
        controller: 'ProjectSettingsController'
    })
    // Submission overview detail
    .state('home.submission-overview', {
        url: '/submission-overview/{submissionId}',
        templateUrl: './views/home/overview/submission.html',
        controller: 'SubmissionOverviewController'
    })
    // Difference overview detail
    .state('home.difference-overview', {
        url: '/project-overview/{projectId}/difference/{differenceArray}',
        templateUrl: './views/home/overview/difference.html',
        controller: 'DifferenceOverviewController'
    })
    // Profile
	.state('home.profile', {
	    url: '/profile',
	    templateUrl: './views/home/profile.html',
	    controller: 'ProfileController'
	});
});

