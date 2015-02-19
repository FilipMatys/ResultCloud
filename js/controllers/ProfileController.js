application.controller('ProfileController', ['$scope', 'UserService', function ($scope, UserService) {
    // Controller variables
    $scope.user = {};

    // Get current user
    UserService.current()
        .success(function (data, status, headers, config) {
            $scope.user = data;
        });

    // Save current user
    $scope.Save = function()	{
	    UserService.save($scope.user)
			.success(function (data, status, headers, config) {
	            // Show status
	            $scope.ShowStatus('Save user', data.IsValid, data.Errors);
	        });
	}
}]);