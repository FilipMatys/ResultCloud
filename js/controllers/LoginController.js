/**
 * Login Controller
 * Author: Filip Matys
 * Description:
 */
application.controller('LoginController', function ($scope, $state, UserService, AuthentizationService, InstallationService) {
	// Variables init
    $scope.credentials = {};
    $scope.errors = [];
    $scope.installed = true;
    $scope.installation = {};
    $scope.installationState = 0;
    $scope.registration = {};
    $scope.registrationStart = false;

    $scope.Install = function () {
        //var credentials = {
        //    Hostname: "127.2.78.130",
        //    Username: "admin1GlTw9z",
        //    Password: "ZCFSCCjU8I_s"
        //};

        InstallationService.install($scope.installation)
            .success(function (data, status, headers, config) {
                $scope.errors = data.Errors;
                $scope.installed = data.IsValid;
                $scope.installationState = data.Data;
            });
    }

    // Check installation
    $scope.CheckInstallation = function () {
        InstallationService.check()
            .success(function (data, status, headers, config) {
                $scope.installed = data.IsValid;
                $scope.installationState = data.Data;
            });
    }

    // Show registration fields
    $scope.Registration = function () {
        $scope.registrationStart = true;
    }

    // Register user
    $scope.Register = function () {
        InstallationService.register($scope.registration)
            .success(function (data, status, headers, config) {
                $scope.installed = data.IsValid;
                $scope.installationState = data.Data;
                $scope.registrationStart = ($scope.installationState == 1);
                $scope.errors = data.Errors;
            });
    }

    // Check installation
    $scope.CheckInstallation();

	// Authorize credentials
	$scope.AuthorizeCredentials = function()	{
		AuthentizationService.authorize($scope.credentials)
			.success(function(data, status, headers, config)	{
				if (data.IsValid == true)	{
					$state.go('home.dashboard');
				}
				else	{
				    $scope.errors = data.Errors;
				}
			});		
	}
});