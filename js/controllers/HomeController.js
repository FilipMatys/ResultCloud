application.controller('HomeController', ['$scope', '$state', 'AuthentizationService', 'UserService', function ($scope, $state, AuthentizationService, UserService) {
    // Init variables
    $scope.user = {};
    $scope.alert = {
        errors: [],
        content: "Pasdas",
        success: false
    };

    // Logout
    $scope.Logout = function () {
        // Deauthorize user
        AuthentizationService.deauthorize()
            .success(function (data, status, headers, config) {
                $scope.user = {};
                $state.go('login');
            });
    }

    /**
     * Show alert
     * operation - operation that was 
     * valid - validity of operation
     * errors - list of errors
     */
    $scope.ShowAlert = function(operation, valid, errors)   {
        // Scroll to top
        $('html, body').animate({scrollTop: 0}, 800);

        // Fill alert object
        var result = valid ? " " : " not ";
        $scope.alert.content = "Operation " + operation + " was" + result + "successful";
        $scope.alert.errors = errors;
        $scope.alert.success = valid; 
    }

    // Clear alert
    $scope.ClearAlert = function()  {
        $scope.alert.content = "";
        $scope.alert.errors = [];
    }

    $scope.ShowAlert('Test', true, []);

    // Get current user
    UserService.current()
        .success(function (data, status, headers, config) {
            $scope.user = data;
        });
}])