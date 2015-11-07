// projectOverviewChart/frontend/projectOverviewChart.js
application.directive('projectOverviewChart', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/components/projectOverviewChart/frontend/template.html',
        controller: function ($scope, $stateParams, ViewService) {
            // Get data for current view
            ViewService.visualize({
                Source: {
                    Id: $stateParams.projectId   
                },
                Identifier: 'project-overview-chart'
			})
			.success(function (data, status, headers, config) {
				$scope.data = data.Data;
			});
        }
    }
});