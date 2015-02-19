application.controller('HomeController', ['$scope', '$state', 'AuthentizationService', 'UserService', function ($scope, $state, AuthentizationService, UserService) {
    // Init variables
    $scope.user = {};
    $scope.status = {
        errors: [],
        content: "",
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
     * Show status
     * operation - operation that was 
     * valid - validity of operation
     * errors - list of errors
     */
    $scope.ShowStatus = function(operation, valid, errors)   {
        // Scroll to top
        $('html, body').animate({scrollTop: 0}, 800);

        // Fill status object
        var result = valid ? " " : " not ";
        $scope.status.content = "Operation " + operation.toUpperCase() + " was" + result + "successful";
        $scope.status.errors = errors;
        $scope.status.success = valid; 
    }

    // Clear status
    $scope.ClearStatus = function()  {
        $scope.status.content = "";
        $scope.status.errors = [];
    }

    // Get current user
    UserService.current()
        .success(function (data, status, headers, config) {
            $scope.user = data;
        });
}])