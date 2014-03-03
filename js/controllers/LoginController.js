/**
 * Login Controller
 * Author: Filip Matys
 * Description:
 */
application.controller('LoginController', function($scope, $state, UserService, AuthentizationService)	{
	// Variables init
	$scope.user = {};
	$scope.credentials = {};
	$scope.registrationSuccess = false;
	$scope.errors = [];

	// Save given user
	$scope.RegisterUser = function()	{
		$scope.registrationSuccess = false;
		$scope.errors = [];

		UserService.save($scope.user)
			.success(function(data, status, headers, config)	{
				if (data.IsValid == true)	{
					$scope.user = {};
					$scope.registrationSuccess = true;
				}
				else	{
					$scope.registrationErrors = data.Errors;
				}
			});
	}

	// Authorize credentials
	$scope.AuthorizeCredentials = function()	{
		$scope.registrationSuccess = false;
		$scope.authorizationSuccess = false;
		$scope.registrationErrors = [];

		AuthentizationService.authorize($scope.credentials)
			.success(function(data, status, headers, config)	{
				if (data.IsValid == true)	{
					$scope.user = {};
					$state.go('home.dashboard');
				}
				else	{
					$scope.errors = data.Errors;
				}
			});		
	}
});