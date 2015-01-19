<?php 
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'Library.utility.php');
Library::using(Library::CORLY_SERVICE_UTILITIES, ['IncludeService.class.php']);
?>

<!doctype html>
<html class="no-js" lang="en" ng-app="CorlyWMT">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Corly | Web Management Tool</title>
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/foundation.min.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/foundation-icons/foundation-icons.css" />
    <script src="js/modernizr.js"></script>
</head>
<body>
    <div class="main-view" ui-view></div>
    <div class="row footer">
        <div class="large-12 columns">
            Corly Management Tool by Filip Matys | Version 2014.1 | 2014/05/20
        </div>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script src="js/angular.min.js" type="text/javascript"></script>
    <script src="js/angular-ui-router.min.js" type="text/javascript"></script>
    <script src="js/angular-file-upload.min.js" type="text/javascript"></script>
    <script src="js/ng-google-chart.js" type="text/javascript"></script>
    <!-- Application controllers -->
    <script src="js/controllers/ApplicationController.js" type="text/javascript"></script>
    <script src="js/factories.js" type="text/javascript"></script>
    <script src="js/controllers/LoginController.js" type="text/javascript"></script>
    <script src="js/controllers/HomeController.js" type="text/javascript"></script>
    <script src="js/controllers/DashboardController.js" type="text/javascript"></script>
    <script src="js/controllers/ImportController.js" type="text/javascript"></script>
    <script src="js/controllers/SettingsController.js" type="text/javascript"></script>
    <script src="js/controllers/UsersController.js" type="text/javascript"></script>
    <script src="js/controllers/PluginManagementController.js" type="text/javascript"></script>
    <script src="js/controllers/ProfileController.js" type="text/javascript"></script>
    <script src="js/controllers/PluginController.js" type="text/javascript"></script>
    <script src="js/controllers/DataOverviewController.js" type="text/javascript"></script>
    <script src="js/controllers/ProjectOverviewController.js" type="text/javascript"></script>
    <script src="js/controllers/SubmissionOverviewController.js" type="text/javascript"></script>
    <script src="js/controllers/DifferenceOverviewController.js" type="text/javascript"></script>
    <script src="js/controllers/ProjectSettingsController.js" type="text/javascript"></script>
    <!-- Visualization directives -->
    <script src="visualization/settings/js/DynamicComponentSettingsLoader.js" type="text/javascript"></script>
    <script src="visualization/submission/js/DynamicSubmissionComponentLoader.js" type="text/javascript"></script>
    <script src="visualization/project/js/DynamicProjectComponentLoader.js" type="text/javascript"></script>
    <script src="visualization/difference/js/DynamicDifferenceComponentLoader.js" type="text/javascript"></script>
    <script src="visualization/components/submissionList/js/SubmissionList.js" type="text/javascript"></script>
    <script src="visualization/components/googleChart/js/GoogleChart.js" type="text/javascript"></script>
    <script src="visualization/components/testCaseList/js/TestCaseList.js" type="text/javascript"></script>
    <script src="visualization/components/difference/js/DifferenceList.js" type="text/javascript"></script>
    <!-- Load plugins components -->
    <?php IncludeService::JsComponents(); ?>

    <script>
        $(document).foundation();
    </script>
</body>
</html>
