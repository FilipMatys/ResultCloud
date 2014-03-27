application.controller('DashboardController', function($scope, InstallationService)	{
	// Variables init

	// FUNCTIONS
    $scope.Install = function () {
        var credentials = {
            Hostname: "localhost",
            Username: "root",
            Password: "xampp"
        };

        InstallationService.install(credentials);
    }
});