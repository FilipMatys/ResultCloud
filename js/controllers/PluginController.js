/**
 * Plugin controller
 */
application.controller('PluginController', ['$scope', '$stateParams', 'PluginService', 'ProjectService', function ($scope, $stateParams, PluginService, ProjectService) {
    // Controller variables
    $scope.plugin = {};
    $scope.showProjectDetail = [];

    // Load given plugin
    var LoadPlugin = function () {
        PluginService.get($stateParams.pluginId)
            .success(function (data, status, headers, config) {
                $scope.plugin = data;
            });
    }

    // Load plugin on page load
    LoadPlugin();

    // Create new project for plugin
    $scope.CreateProject = function () {
        // Initialize project
        var project = {
            Name: $scope.projectName,
            Plugin: $scope.plugin.Id
        };

        // Reset project name
        $scope.projectName = "";

        // Save project
        ProjectService.save(project)
            .success(function (data, status, headers, config) {
                LoadPlugin();
            });
    };

    // Toggle project detail
    $scope.ToggleProjectDetail = function (index) {
        $scope.showProjectDetail[index] = !$scope.showProjectDetail[index];
    }


}]);