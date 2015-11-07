application.directive('corlyComponentSettingsLoader', function () {
    return {
        restrict: 'E',
        templateUrl: 'visualization/loaders/templates/settings.html',
        controller: function ($scope, $stateParams, TemplateSettingsService) {
		  // Init settings
          $scope.settings = {
              Type: 0,
              View: 9
          };
          
          $scope.setActiveTab = function(stype, sview) {
              $scope.settings = {
                  Type: stype,
                  View: sview
              }
          }  
    
            // Load settings
            var loadSettings = function()   {
                TemplateSettingsService.get({
                    Id: $stateParams.projectId
                })
                .success(function (data, status, headers, config) {
                    $scope.templates = angular.copy(data);
                    $scope.backup = data;
                });
            }
    
            // Save settings
            $scope.Save =  function()   {
                    TemplateSettingsService.save($scope.templates)
                    .success(function (data, status, headers, config) {
                        // Show status
                        $scope.ShowStatus('Save settings', data.IsValid, data.Errors);
                    });
            }
            
            $scope.Reset = function() {
                $scope.templates = angular.copy($scope.backup);
            }
            
            loadSettings();
        }
    }
});