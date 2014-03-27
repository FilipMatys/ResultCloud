application.controller('ImportController', [ '$scope' , '$upload', function ($scope, $upload) {
    // Init variables
    $scope.selectedFile = {};
    $scope.import = {};
    $scope.valid = true;

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
    
            console.log(success);
        }).progress(function (evt) {
            $('#upload-progress').width(parseInt(100.0 * evt.loaded / evt.total) + '%');
        });
        //.error(...)
        //.then(success, error, progress); 
    }

}]);