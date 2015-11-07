// submissionOverviewChart/frontend/submissionOverviewChart.js
application.directive('submissionOverviewChart', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/components/submissionOverviewChart/frontend/template.html',
        controller: function ($scope, $stateParams, ViewService) {
            // Get data for current view
            ViewService.visualize({
                Source: {
                    Id: $stateParams.submissionId   
                },
                Identifier: 'submission-overview-chart'
			})
			.success(function (data, status, headers, config) {
				$scope.data = data.Data;
			});
        }
    }
});