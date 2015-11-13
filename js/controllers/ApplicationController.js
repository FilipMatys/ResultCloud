var application = angular.module('CorlyWMT', [
		'ui.router',
        'angularFileUpload',
        'googlechart'
	]);

// Load foundation on every new page load
application.run(function($rootScope, $timeout)	{
	$rootScope.$on('$viewContentLoaded', function()	{
		$timeout(function()	{
			$(".button-collapse").sideNav();
			$('.collapsible').collapsible();
			$('.dropdown-button').dropdown();
			$('.tooltipped').tooltip({delay: 50});
			$('select').material_select();
		}, 500);
	})
});

// Keep track of routing and keep non authorized users away
application.run(['$rootScope', '$location', 'SessionService', function ($rootScope, $location, SessionService) {
    // Array of routes, that do require login
    var routesThatRequireAuth = ['/import', '/settings', '/project-settings', '/profile'];

    // Wait  for location to change
    $rootScope.$on('$stateChangeStart', function (event, next) {
        // Check route
        if (routesThatRequireAuth.indexOf($location.path()) < 0)   {
            return;
        }
        // If routes requires auth, than check current user
        else {
            // Check session
            SessionService.check().success(function (data, status, headers, config) {
                // Check result
                if (data === "false")
                    $location.path('/');
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

	// Home page
	.state('home', {
	    url: '/',
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
	    url: 'import',
	    templateUrl: './views/home/import.html',
	    controller: 'ImportController'
	})
    // Settings - users
	.state('home.settings-users', {
	    url: 'settings/users',
	    templateUrl: './views/home/settings/users.html',
	    controller: 'UsersController'
	})
	// Settings - release notes
	.state('home.settings-release-notes', {
	    url: 'settings/release-notes',
	    templateUrl: './views/home/settings/release.html',
	    controller: 'ReleaseNotesController'
	})
    // Plugin management
	.state('home.plugin-management', {
	    url: 'settings/plugin-management',
	    templateUrl: './views/home/pluginManagement.html',
	    controller: 'PluginManagementController'
	})
    // Data overview
	.state('home.data-overview', {
	    url: 'data-overview',
	    templateUrl: './views/home/dataOverview.html',
	    controller: 'DataOverviewController'
	})
    // Plugin detail
    .state('home.plugin', {
        url: 'plugin-overview/{pluginId}',
        templateUrl: './views/home/plugin.html',
        controller: 'PluginController'
    })
    // Project overview detail
    .state('home.project-overview', {
        url: 'project/{projectId}',
        templateUrl: './views/home/overview/project.html',
        controller: 'ProjectOverviewController'
    })
    // Project overview detail
    .state('home.project-settings', {
        url: 'project-settings/{projectId}',
        templateUrl: './views/home/projectSettings.html',
        controller: 'ProjectSettingsController'
    })
    // Submission overview detail
    .state('home.submission-overview', {
        url: 'project/{projectId}/submission/{submissionId}',
        templateUrl: './views/home/overview/submission.html',
        controller: 'SubmissionOverviewController'
    })
    // Difference overview detail
    .state('home.difference-overview', {
        url: 'project/{projectId}/difference/{differenceArray}',
        templateUrl: './views/home/overview/difference.html',
        controller: 'DifferenceOverviewController'
    })
    // Profile
	.state('home.profile', {
	    url: 'profile',
	    templateUrl: './views/home/profile.html',
	    controller: 'ProfileController'
	})
});