application.controller('ImportController', ['$scope', '$upload', 'PluginService', 'ProjectService', function ($scope, $upload, PluginService, ProjectService) {
    // Init variables
    $scope.selectedFile = {};
    $scope.import = {};
    $scope.valid = true;
    $scope.plugins = [];
    $scope.projects = [];
    $scope.PendingChanges = false;

    // Load installed plugins
    PluginService.query()
        .success(function (data, status, headers, config) {
            $scope.plugins = data;
        });

    // Get projects for chosen plugin
    $scope.LoadProjects = function () {
        // Reset project selection
        $scope.import.Project = null;

        // Load projects for given plugin
        ProjectService.plugin($scope.import.Plugin)
            .success(function (data, status, headers, config) {
                $scope.projects = data;
            });
    }

    /**
     * Assign file 
     */
    $scope.onFileSelect = function ($file) {
        $scope.selectedFile = $file[0];
        $('#upload-progress').width(0 + '%');
    };

    /**
     * Upload given file
     */
    $scope.uploadFile = function () {
        $scope.PendingChanges = true;
        $scope.upload = $upload.upload({
            url: 'api/ImportController.class.php?method=IMPORT',
            data: {
                data: $scope.import
            },
            file: $scope.selectedFile,
        }).then(function (success, error, progress) {
            // file is uploaded successfully
            $scope.valid = success.data.IsValid;
            $('#upload-progress').width(100 + '%');
            $scope.PendingChanges = false;
    
            console.log(success);
        }).progress(function (evt) {
            $('#upload-progress').width(parseInt(100.0 * evt.loaded / evt.total) + '%');
        });
        //.error(...)
        //.then(success, error, progress); 
    }

}]);