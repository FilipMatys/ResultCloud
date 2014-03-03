// OfferService
application.factory('OfferService', function($http) {
	return	{
		query: function()	{
			return $http({
				method: 'GET',
				url: 'api/OfferController.class.php?method=QUERY'
			})
		},
		queryOffers: function()	{
			return $http({
				method: 'GET',
				url: 'api/OfferController.class.php?method=QUERY_OFFERS'
			})
		},
		queryApplications: function()	{
			return $http({
				method: 'GET',
				url: 'api/OfferController.class.php?method=QUERY_APPLICATIONS'
			})
		},
		get: function(offer)	{
			return $http({
				method: 'POST',
				url: 'api/OfferController.class.php?method=GET',
				data: offer
			})
		},
		save: function(offer)	{
			return $http({
				method: 'POST',
				url: 'api/OfferController.class.php?method=SAVE',
				data: offer

			})
		},
		changeStatus: function(offer)	{
			return $http({
				method: 'POST',
				url: 'api/OfferController.class.php?method=CHANGE_STATUS',
				data: offer
			})
		}
	}
});

// OfferRelationService
application.factory('OfferRelationService', function($http) {
	return	{
		save: function(offerRelation)	{
			return $http({
				method: 'POST',
				url: 'api/OfferRelationController.class.php?method=SAVE',
				data: offerRelation

			})
		},
		count: function(offer)	{
			return $http({
				method: 'POST',
				url: 'api/OfferRelationController.class.php?method=COUNT',
				data: offer
			})
		},
		candidates: function(offer)	{
			return $http({
				method: 'POST',
				url: 'api/OfferRelationController.class.php?method=CANDIDATES',
				data: offer
			})
		}
	}
});

// User service
application.factory('UserService', function($http)	{
	return	{
		query: function()	{
			return $http({
				method: 'GET',
				url: 'api/UserController.class.php?method=QUERY'
			})
		},
		get: function(user)	{
			return $http({
				method: 'POST',
				url: 'api/UserController.class.php?method=GET',
				data: user
			})
		},
		save: function(user)	{
			return $http({
				method: 'POST',
				url: 'api/UserController.class.php?method=SAVE',
				data: user

			})
		}
	}
});

// Authentization service
application.factory('AuthentizationService', function($http)	{
	return	{
		authorize: function(credentials)	{
			return $http({
				method: 'POST',
				url: 'api/AuthentizationController.class.php?method=AUTHORIZE',
				data: credentials
			})
		}
	}
});