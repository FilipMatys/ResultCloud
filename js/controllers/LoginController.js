/**
 * Login Controller
 * Author: Filip Matys
 * Description:
 */
application.controller('LoginController', function($scope, $state, UserService, AuthentizationService)	{
	// Variables init
	$scope.credentials = {};

	// Authorize credentials
	$scope.AuthorizeCredentials = function()	{
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