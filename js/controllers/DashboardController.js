application.controller('DashboardController', function($scope, PluginService, SubmissionService)	{
    // Controller variables
    $scope.plugins = [];
	$scope.recentImports = [];

    // Load plugins
    PluginService.query()
        .success(function (data, status, headers, config) {
            $scope.plugins = data;
        });

    // Load recent submissions
    SubmissionService.recent()
		.success(function (data, status, headers, config) {
            $scope.recentImports = data;
        });    	
});