/** 
 *   PluginOverviewController.js
 */
application.controller('PluginOverviewController', ['$scope', '$stateParams', 'PluginService', function ($scope, $stateParams, PluginService) {
    // Controller variables
    $scope.plugin = {};

    // Load given plugin
    var LoadPlugin = function () {
        PluginService.get($stateParams.pluginId)
            .success(function (data, status, headers, config) {
                $scope.plugin = data;
            });
    }

    // Load plugin on page load
    LoadPlugin();
}]);