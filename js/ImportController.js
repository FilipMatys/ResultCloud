application.controller('ImportController', ['$scope', '$upload', function($scope, $upload) {
        $scope.File = "";

        // Open file explorer
        $scope.selectFile = function()  {
            $('#fileExplorer').click();
        };

        // Upload file 
        $scope.onFileSelect = function($files) {
            //$files: an array of files selected, each file has name, size, and type.
            for (var i = 0; i < $files.length; i++) {
                var $file = $files[i];
                $scope.File = $file.name;
                $scope.upload = $upload.upload({
                    url: './api/ImportController.php', //upload.php script, node.js route, or servlet url
                    method: 'POST',
                    file: $file
                }).progress(function(evt) {
                    $('#import-progress-bar').width(parseInt(100.0 * evt.loaded / evt.total) + '%');
                }).success(function(data, status, headers, config) {
                    // file is uploaded successfully
                    console.log(data);
                });
                //.error(...)
                //.then(success, error, progress); 
            }
        };


    }]);