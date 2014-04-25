/**
 * Plugin management controller
 */
application.controller('PluginManagementController', ['$scope', 'PluginService', 'PluginManagementService', function ($scope, PluginService, PluginManagementService) {
    // Controller variables
    $scope.Plugins = [];
    $scope.NotInstalled = [];
    $scope.PendingChanges = false;
    $scope.PendingInstallation = [];


    // Load plugins
    $scope.FetchPlugins = function () {
        PluginService.query()
            .success(function (data, status, headers, config) {
                $scope.Plugins = data;
            });
    }

    $scope.FetchPlugins();

    $scope.ScanForPlugins = function () {
        $scope.PendingChanges = true;
        PluginManagementService.notinstalled()
            .success(function (data, status, headers, config) {
                $scope.NotInstalled = data;
                $scope.PendingChanges = false;
            });
    }

    $scope.InstallPlugin = function (plugin, index) {
        $scope.PendingInstallation[index] = true;
        PluginManagementService.install(plugin)
            .success(function (data, status, headers, config) {
                $scope.PendingInstallation[index] = false;
                $scope.FetchPlugins();
                $scope.ScanForPlugins();
            });
    }
}]);