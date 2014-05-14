/**
 * Login Controller
 * Author: Filip Matys
 * Description:
 */
application.controller('LoginController', function ($scope, $state, UserService, AuthentizationService, InstallationService) {
	// Variables init
    $scope.credentials = {};
    $scope.errors = [];

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

	// Authorize credentials
	$scope.AuthorizeCredentials = function()	{
		AuthentizationService.authorize($scope.credentials)
			.success(function(data, status, headers, config)	{
				if (data.IsValid == true)	{
					$state.go('home.dashboard');
				}
				else	{
				    $scope.errors = data.Errors;
				    console.log($scope.errors);
				}
			});		
	}
});