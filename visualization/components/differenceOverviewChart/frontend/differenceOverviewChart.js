// differenceOverviewChart/frontend/differenceOverviewChart.js
application.directive('differenceOverviewChart', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/components/differenceOverviewChart/frontend/template.html',
        controller: function ($scope, $stateParams, ViewService) {
            // Get data for current view
            ViewService.visualize({
                Source: {
                        Submissions: $stateParams.differenceArray   
                },
                Identifier: 'difference-overview-chart'
			})
			.success(function (data, status, headers, config) {
				$scope.data = data.Data;
			});
        }
    }
});