<?php
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

	// Get libraries
	Library::using(Library::UTILITIES);
	Library::using(Library::CORLY_ENTITIES);
	Library::using(Library::CORLY_SERVICE_SUITE);
	Library::using(Library::CORLY_SERVICE_UTILITIES);
	Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);
	Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryDao.class.php']);
	Library::usingProject(dirname(__FILE__));

	class PluginServices {
		public static function DeleteSubmission($submission) {
			//Delete configuration
	        $configurationHandler = DbUtil::GetEntityHandler(new SystemTAP_Configuration);
	        $lConfiguration = $configurationHandler->DeleteFilteredList(QueryParameter::Where('DateTime', $submission->DateTime));

	        // Clear submission and delete project
	        FactoryService::CategoryService()->ClearCategory($submission->Id);
	        FactoryDao::SubmissionDao()->Delete($submission);

	        $validation = new ValidationResult(new stdClass());
        	return $validation;
		}
	}
?>