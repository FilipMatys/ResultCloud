application.factory("AuthorizationService", function($http) {
    return {
        login: function(credentials) {
            return $http({
                method: 'POST', url: './api/LoginController.php?method=authorize', 
                data: credentials
            });
        },
        logout: function() {
            return $http({
                method: 'POST', url: './api/LoginController.php?method=deauthorize'
            });
        }
    };
});

application.factory("UserService", function($http) {
    return {
        get: function(credentials) {
            return $http({
                method: 'GET', url: './api/UserController.php?method=get' 
            });
        },
        save: function(user) {
            return $http({
                method: 'POST', url: './api/UserController.php?method=save',
                data: user
            });
        }
    };
});

application.factory("ProfileService", function($http) {
    return {
        get: function() {
            return $http({
                method: 'GET', url: './api/ProfileController.php?method=get' 
            });
        },
        save: function(user) {
            return $http({
                method: 'POST', url: './api/ProfileController.php?method=save',
                data: user
            });
        }
    };
});