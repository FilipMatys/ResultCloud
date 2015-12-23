application.controller('InstallationController', ['$scope', '$state', 'InstallationService', function ($scope, $state, InstallationService) {
    // Init variables
    $scope.installation = {
        User: {}
    }
    
    // Install app
    $scope.install = function() {
        InstallationService.install($scope.installation)
        .success(function (data, status, headers, config) {
                if (data.IsValid)   {
                    $state.go('home.dashboard');
                }
            });
    }
}]);