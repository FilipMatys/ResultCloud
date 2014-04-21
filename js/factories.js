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
		}
	}
});

// Submission service
application.factory('SubmissionService', function ($http) {
    return {
        get: function (submissionId) {
            return $http({
                method: 'POST',
                url: 'api/SubmissionController.class.php?method=GET',
                data: submissionId
            })
        },
        difference: function (data) {
            return $http({
                method: 'POST',
                url: 'api/SubmissionController.class.php?method=DIFFERENCE',
                data: data
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
    }
}]);