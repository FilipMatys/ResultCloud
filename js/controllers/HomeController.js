application.controller('HomeController', ['$scope', '$state', 'AuthentizationService', 'UserService', 'InstallationService', function ($scope, $state, AuthentizationService, UserService, InstallationService) {
    // Init variables
    $scope.user = null;
    $scope.credentials = {};
    $scope.registration = {};
    $scope.logInModalForm = true;
    $scope.status = {
        errors: [],
        content: "",
        success: false
    };

    // Logout
    $scope.Logout = function () {
        // Deauthorize user
        AuthentizationService.deauthorize()
            .success(function (data, status, headers, config) {
                $scope.user = null;
            });
    }
    
    // Authorize credentials
	$scope.AuthorizeCredentials = function()	{
		AuthentizationService.authorize($scope.credentials)
			.success(function(data, status, headers, config)	{
				if (data.IsValid == true)	{
					$scope.GetCurrentUser();
                    $scope.credentials = {};
                    $scope.CloseModal('login-modal');
				}
				else	{
				    $scope.errors = data.Errors;
				}
			});		
	}
    
    // Register user
    $scope.Register = function () {
        InstallationService.register($scope.registration)
            .success(function (data, status, headers, config) {
                // Assign errors
                $scope.errors = data.Errors;
                
                // Check if registration was successful
                if ($scope.errors.length == 0)
                    $scope.logInModalForm = true;
                
            });
    }
    
    $scope.SwitchToRegistrationForm = function()    {
        $scope.logInModalForm = false;
    }
    
    $scope.SwitchToLogInForm = function()   {
        $scope.logInModalForm = true;
    }

    // Open settings
    $scope.OpenSettings = function()    {
        $('#settings-modal').openModal();
    }
    
    // Log in modal
    $scope.LogInModal = function()  {
        $scope.logInModalForm = true;
        $('#login-modal').openModal();
    }
    
    $scope.CloseLogInModal = function ()    {
        $('#login-modal').closeModal();
    }

    // Go to state
    $scope.GoTo = function(dest)    {
        $('#settings-modal').closeModal();
        $state.go(dest);
    }

    $scope.OpenModal = function(modal)  {
        $('#' + modal).openModal();
    }

    $scope.CloseModal = function(modal) {
        $('#' + modal).closeModal();
    }

    $scope.LoadingUp = function()   {
        $('#loading-modal').openModal({
            dismissible: false
        });
    }

    $scope.LoadingDown = function() {
        $('#loading-modal').closeModal();
    }

    /**
     * Show status
     * operation - operation that was 
     * valid - validity of operation
     * errors - list of errors
     */
    $scope.ShowStatus = function(operation, valid, errors)   {
        // Fill status object
        var result = valid ? " " : " not ";
        $scope.status.content = "Operation " + operation.toUpperCase() + " was" + result + "successful";
        $scope.status.errors = errors;
        $scope.status.success = valid; 

        Materialize.toast($scope.status.content, 4000);
        // TODO ERRORS
    }

    // Clear status
    $scope.ClearStatus = function()  {
        $scope.status.content = "";
        $scope.status.errors = [];
    }

    // Get current user
    $scope.GetCurrentUser = function() {
        UserService.current()
        .success(function (data, status, headers, config) {
            // Check if user found
            if (data.Person)
                $scope.user = data;
        });       
    }
    
    $scope.GetCurrentUser();
 
}])