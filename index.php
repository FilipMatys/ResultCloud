<?php 
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'Library.utility.php');
Library::using(Library::CORLY_SERVICE_UTILITIES, ['IncludeService.class.php']);
Library::using(Library::UTILITIES, ['DatabaseDriver.php']);
?>

<!doctype html>
<html class="no-js" lang="en" ng-app="CorlyWMT">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ResultCloud | Web Management Tool</title>
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css" />
</head>
<body>
    <div class="main-view" ui-view></div>
    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/materialize.min.js"></script>
    <script src="js/angular.min.js" type="text/javascript"></script>
    <script src="js/angular-ui-router.min.js" type="text/javascript"></script>
    <script src="js/angular-file-upload.min.js" type="text/javascript"></script>
    <script src="js/ng-google-chart.js" type="text/javascript"></script>
    <!-- Application controllers -->
    <script src="js/controllers/ApplicationController.js" type="text/javascript"></script>
    <script src="js/factories.js" type="text/javascript"></script>
    <script src="js/controllers/InstallationController.js" type="text/javascript"></script>
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
    <script src="js/controllers/ProjectDashboardController.js" type="text/javascript"></script>
    <script src="js/controllers/ReleaseNotesController.js" type="text/javascript"></script>

    <!-- Visualization directives -->
    <script src="visualization/loaders/DynamicComponentSettingsLoader.js" type="text/javascript"></script>
    <script src="visualization/loaders/DynamicComponentLoaderTabbed.js" type="text/javascript"></script>
    <script src="visualization/loaders/DynamicComponentLoader.js" type="text/javascript"></script>
    <script src="visualization/tools/googleChart/js/GoogleChart.js" type="text/javascript"></script>
    <script src="visualization/tools/submissionOverviewList/js/submissionOverviewList.js" type="text/javascript"></script>
    <script src="visualization/tools/differenceOverviewList/js/differenceOverviewList.js" type="text/javascript"></script>
    <!-- Load plugins components -->
    <?php IncludeService::JsComponents(); ?>

    <script>
        $(document).ready(function()    {

        });
    </script>
</body>
</html>
