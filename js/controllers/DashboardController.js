application.controller('DashboardController', function($scope, InstallationService)	{
	// Variables init

	// FUNCTIONS
    $scope.Install = function () {
        //var credentials = {
        //    Hostname: "127.2.78.130",
        //    Username: "admin1GlTw9z",
        //    Password: "ZCFSCCjU8I_s"
        //};

        var credentials = {
            Hostname: "localhost",
            Username: "root",
            Password: "xampp"
        }

        InstallationService.install(credentials);
    }
});