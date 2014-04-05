/**
 * Plugin management controller
 */
application.controller('PluginManagementController', ['$scope', 'PluginService', function ($scope, PluginService) {
    // Controller variables
    $scope.Plugins = [];


    // Load plugins
    PluginService.query()
        .success(function (data, status, headers, config) {
            $scope.Plugins = data;
        });
}]);