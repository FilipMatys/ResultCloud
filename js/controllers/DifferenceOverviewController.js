/**
    DifferenceOverviewController.js
 */
application.controller('DifferenceOverviewController', ['$scope', '$stateParams', 'PathService', function ($scope, $stateParams, PathService) {
    $scope.path = {};

    PathService.path({
        Type: "DIFFERENCE",
        EntityId: $stateParams.projectId
    })
    .success(function (data, status, headers, config) {
        $scope.path = data;
    });
}]);