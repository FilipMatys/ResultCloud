/** 
    Data overview controller
*/
application.controller('DataOverviewController', ['$scope', 'PluginService', function ($scope, PluginService) {
    // Controller variables
    $scope.Plugins = [];


    // Load plugins
    PluginService.query()
        .success(function (data, status, headers, config) {
            $scope.Plugins = data;
        });

}]);