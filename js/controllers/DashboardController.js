application.controller('DashboardController', function($scope, OfferService)	{
	// Variables init
	$scope.offerList = [];

	// FUNCTIONS
	/**
	 * Fetch offers 
	 */
	 var FetchOffers = function()	{
		OfferService.query()
		.success(function(data, status, headers, config)	{
				$scope.offerList = data;
			});
	 }

	 // INIT WORKSPACE
	 // Fetch offers
	 FetchOffers();
});