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

    // Fetch plugins
    $scope.FetchPlugins();

    // Scan for not installed plugins
    $scope.ScanForPlugins = function () {
        // Set pending changes
        $scope.PendingChanges = true;
        // Scan
        PluginManagementService.notinstalled()
            .success(function (data, status, headers, config) {
                // Set data
                $scope.NotInstalled = data;
                $scope.PendingChanges = false;
            });
    }

    // Install given plugin
    $scope.InstallPlugin = function (plugin, index) {
        // Set pending changes for plugin
        $scope.PendingInstallation[index] = true;
        // Install
        PluginManagementService.install(plugin)
            .success(function (data, status, headers, config) {
                // Refresh page content
                $scope.PendingInstallation[index] = false;
                $scope.FetchPlugins();
                $scope.ScanForPlugins();
            });
    }
}]);