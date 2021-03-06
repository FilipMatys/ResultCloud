// User service
application.factory('UserService', function($http)	{
	return	{
		query: function()	{
			return $http({
				method: 'GET',
				url: 'api/UserController.class.php?method=QUERY'
			})
		},
		get: function(user)	{
			return $http({
				method: 'POST',
				url: 'api/UserController.class.php?method=GET',
				data: user
			})
		},
		save: function(user)	{
			return $http({
				method: 'POST',
				url: 'api/UserController.class.php?method=SAVE',
				data: user

			})
		},
		current: function () {
		    return $http({
		        method: 'GET',
		        url: 'api/UserController.class.php?method=CURRENT',
		    })
		}
	}
});

// Session service
application.factory('SessionService', function ($http) {
    return {
        check: function () {
            return $http({
                method: 'GET',
                url: 'api/SessionController.class.php?method=CHECK'
            })
        }
    }
});

// View service
application.factory('ViewService', function ($http) {
    return {
        views: function (data) {
            return $http({
                method: 'POST',
                url: 'api/ViewController.class.php?method=VIEWS',
                data: data
            })
        },
        visualize: function (data) {
            return $http({
                method: 'POST',
                url: 'api/ViewController.class.php?method=VISUALIZE',
                data: data
            })
        }
    }
});

// Session service
application.factory('TemplateSettingsService', function ($http) {
    return {
        get: function (project) {
            return $http({
                method: 'POST',
                url: 'api/TemplateSettingsController.class.php?method=GET',
                data: project
            })
        },
        save: function (templateSettings) {
            return $http({
                method: 'POST',
                url: 'api/TemplateSettingsController.class.php?method=SAVE',
                data: templateSettings
            })
        }
    }
});

// Plugin management service
application.factory('PluginManagementService', function ($http) {
    return {
        notinstalled: function () {
            return $http({
                method: 'GET',
                url: 'api/PluginManagementController.class.php?method=UNINSTALLED'
            })
        },
        install: function (plugin) {
            return $http({
                method: 'POST',
                url: 'api/PluginManagementController.class.php?method=INSTALLP',
                data: plugin
            })
        },
        components: function () {
            return $http({
                method: 'GET',
                url: 'api/PluginManagementController.class.php?method=COMPONENTS'
            })
        },
        installComponent: function (component) {
            return $http({
                method: 'POST',
                url: 'api/PluginManagementController.class.php?method=INSTALLC',
                data: component
            })
        },
    }
});

// Path service
application.factory('PathService', function ($http) {
    return {
        path: function (request) {
            return $http({
                method: 'POST',
                url: 'api/PathController.class.php?method=PATH',
                data: request
            })
        }
    }
});

// Submission service
application.factory('SubmissionService', function ($http) {
    return {
        recent: function()  {
            return $http({
                method: 'GET',
                url: 'api/SubmissionController.class.php?method=RECENT',
            })
        }
    }
});

// Installation service
application.factory('InstallationService', function ($http) {
    return {
        install: function (credentials) {
            return $http({
                method: 'POST',
                url: 'api/InstallationController.class.php?method=INSTALL',
                data: credentials
            })
        },
        check: function () {
            return $http({
                method: 'GET',
                url: 'api/InstallationController.class.php?method=CHECK',
            })
        },
        register: function (registration) {
            return $http({
                method: 'POST',
                url: 'api/InstallationController.class.php?method=REGISTER',
                data: registration
            })
        }
    }
});

// Authentization service
application.factory('AuthentizationService', function($http)	{
	return	{
		authorize: function(credentials)	{
			return $http({
				method: 'POST',
				url: 'api/AuthentizationController.class.php?method=AUTHORIZE',
				data: credentials
			})
		},
		deauthorize: function () {
		    return $http({
		        method: 'GET',
		        url: 'api/AuthentizationController.class.php?method=DEAUTHORIZE',
		    })
		}
	}
});

// Plugin service
application.factory('PluginService', ['$http', function ($http) {
    return {
        query: function () {
            return $http({
                method: 'GET',
                url: 'api/PluginController.class.php?method=QUERY'
            })
        },
        get: function (pluginId) {
            return $http({
                method: 'POST',
                url: 'api/PluginController.class.php?method=GET',
                data: pluginId
            })
        },
        getWithLiveness: function (pluginId) {
            return $http({
                method: 'POST',
                url: 'api/PluginController.class.php?method=GET_L',
                data: pluginId
            })
        },
        queryWithLiveness: function () {
            return $http({
                method: 'GET',
                url: 'api/PluginController.class.php?method=QUERY_L'
            })
        }
    }
}]);

// Project service
application.factory('ProjectService', ['$http', function ($http) {
    return {
        query: function (pluginId) {
            return $http({
                method: 'POST',
                url: 'api/ProjectController.class.php?method=QUERY',
                data: pluginId
            })
        },
        save: function (project) {
            return $http({
                method: 'POST',
                url: 'api/ProjectController.class.php?method=SAVE',
                data: project
            })
        },
        plugin: function (pluginId) {
            return $http({
                method: 'POST',
                url: 'api/ProjectController.class.php?method=PLUGIN',
                data: pluginId
            })
        },
        get: function (projectId) {
            return $http({
                method: 'POST',
                url: 'api/ProjectController.class.php?method=GET',
                data: projectId
            })
        },
        clear: function (projectId) {
            return $http({
                method: 'POST',
                url: 'api/ProjectController.class.php?method=CLEAR',
                data: projectId
            })
        },
        projectDelete: function (projectId) {
            return $http({
                method: 'POST',
                url: 'api/ProjectController.class.php?method=DELETE',
                data: projectId
            })
        },
        submissionDelete: function (Ids) {
            return $http({
                method: 'POST',
                url: 'api/ProjectController.class.php?method=DELETE_SUBMISSION',
                data: Ids
            })
        }
    }
}]);

// Update service
application.factory('UpdateService', ['$http', function ($http) {
    return {
        check: function () {
            return $http({
                method: 'GET',
                url: 'api/UpdateController.class.php?method=CHECK'
            })
        }
    }
}]);