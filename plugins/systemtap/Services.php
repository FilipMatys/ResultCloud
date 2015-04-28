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

	        //Get next submission
	        $sub_query = FactoryDao::SubmissionDao()->GetFilteredList(QueryParameter::WhereGreater("Id", $submission->Id), new QueryPagination(1, 1, "DESC"));
	        if (!$sub_query->IsEmpty())
	        {
	            //Load all information about submission
	            $submission_tse = new SubmissionTSE();
	            $submission_tse->MapDbObject($sub_query->Single());
	            TestSuiteDataService::LoadCategories($submission_tse, Visualization::GetDifferenceDataDepth(DifferenceOverviewType::VIEWLIST));

	            $submissions = array(2);
	            $submissions[1] = $submission_tse;
	            //Load previous submission
	            $sub_query = FactoryDao::SubmissionDao()->GetFilteredList(QueryParameter::WhereLess("Id", $submission->Id), new QueryPagination(1, 1, ""));
	            if (!$sub_query->IsEmpty())
	            {
	                //Load all information about submission
	                $submission_tse2 = new SubmissionTSE();
	                $submission_tse2->MapDbObject($sub_query->Single());
	                TestSuiteDataService::LoadCategories($submission_tse2, Visualization::GetDifferenceDataDepth(DifferenceOverviewType::VIEWLIST));
	                $submissions[0] = $submission_tse2;

	                //Compute difference
	                $result = Parser::GetDifferenceCount($submissions);
	                $result->Id = $submissions[1]->GetId();
	                FactoryDao::SubmissionDao()->Save($result);
	                $validation = new ValidationResult($result);

        			return $validation;

	            }
	            else{
	                //if deleted submission was first, change all difference to 0
	                $result = new stdClass();
	                $result->Good = 0;
	                $result->Bad = 0;
	                $result->Strange = 0;
	                $result->Id = $submissions[1]->GetId();
	                FactoryDao::SubmissionDao()->Save($result);
	                $validation = new ValidationResult($result);

        			return $validation;
	            }
	        }
	        $validation = new ValidationResult(new stdClass());
        	return $validation;
		}
	}
?>