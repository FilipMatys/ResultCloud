/**
    PublicProjectsController.js
 */
application.controller('PublicProjectsController', ['$scope', '$stateParams', 'PluginService', function ($scope, $stateParams, PluginService) {
	PluginService.queryWithLiveness()
            .success(function (data, status, headers, config) {
                $scope.plugins = data;
            });
}]);