/**
 * Plugin management controller
 */
application.controller('PluginManagementController', ['$scope', 'PluginService', 'PluginManagementService', function ($scope, PluginService, PluginManagementService) {
    /**
     * VARIABLES
     */
    $scope.Plugins = [];
    $scope.Components = [];
    $scope.NotInstalled = [];
    $scope.PendingChanges = false;
    $scope.PendingInstallation = [];
    $scope.pluginTab = true;
    $scope.componentTab = false;
    
    $scope.ViewTypes = [
        {
            ViewType: '0',
            Name: 'Submission'
        },
        {
            ViewType: '1',
            Name: 'Difference'
        },
        {
            ViewType: '2',
            Name: 'Project'
        },
        {
            ViewType: '',
            Name: 'All'
        }
    ]
    
    /**
     * GUI CONTROLS
     */
    $scope.showPlugins = function()    {
        $scope.pluginTab = true;
        $scope.componentTab = false;
    }
    
    $scope.showComponents = function()  {
        $scope.pluginTab = false;
        $scope.componentTab = true;
    }
    
    /**
     * DATA LOAD
     */

    // Load plugins
    $scope.FetchPlugins = function () {
        PluginService.query()
            .success(function (data, status, headers, config) {
                $scope.Plugins = data;
            });
    }
    
    // Load components
    $scope.FetchComponents = function () {
        PluginManagementService.components()
            .success(function (data, status, headers, config) {
                $scope.Components = data;
            });
    }

    // Fetch plugins and components
    $scope.FetchPlugins();
    $scope.FetchComponents();

    // Scan
    PluginManagementService.notinstalled()
        .success(function (data, status, headers, config) {
            // Set data
            $scope.NotInstalled = data;
        });
        
    /**
     * ACTIONS
     */
    
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
    
    // Install component
    $scope.InstallComponent = function(component)   {
        // Install
        PluginManagementService.installComponent(component)
            .success(function (data, status, headers, config) {
                // Refresh component list
                $scope.FetchComponents();
            });
    }
}]);