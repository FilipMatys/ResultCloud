<?php
	/**
	 * Class to get submission details with API
	 * @author Filip Matys
	 */
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');
	
	// Include files
    Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryDao.class.php']);
    Library::using(Library::EXTENTIONS_SUMMARIZERS);
	Library::using(Library::UTILITIES);


	class submissions {
        // Get list of submissions
		public function getList($params) {
            // Load submissions for given project
            $submissions = FactoryDao::SubmissionDao()->GetFilteredList(QueryParameter::Where('Project', $params['project']))->ToList();

            $out_data = new ValidationResult(new stdClass());
            $out_data->Add("Result", $submissions);

			// Return data
			return $out_data->toJSON();
		}

        // Get submission by hash
        public function getByHash($params)    {
            $data = new stdClass();
            $data->GitHash = $params['hash'];

            // Include summarizer
            include_once(Library::path(Library::EXTENTIONS_SUMMARIZERS.DIRECTORY_SEPARATOR.'summarizers', 'RevisionChangeFlagSummary.php'));

            // Init revision change flags summary handler
            $name = "RevisionChangeFlagSummary";
            $sEH = DbUtil::GetEntityHandler(new $name());

            // Load submission
            $submission = FactoryDao::SubmissionDao()->GetFilteredList(QueryParameter::Where('GitHash', $data->GitHash))->Single();
            
            // Load categories into submission
            $submission->Categories = FactoryDao::CategoryDao()->GetFilteredList(QueryParameter::Where('Submission', $submission->Id))->ToList();
            
            // Load test cases for each category
            foreach ($submission->Categories as &$category)
            {
            	// First load test cases
                $category->TestCases = FactoryDao::TestCaseDao()->GetFilteredList(QueryParameter::Where('Category', $category->Id))->ToList();

                // And now for each test case load its revision info
                foreach ($category->TestCases as &$testCase)
                {
                    // Load revision and if is set
                	$revision = $sEH->GetFilteredList(QueryParameter::Where('TestCase', $testCase->Id))->Single();
                    $testCase->ChangeFlag = is_null($revision) ? 0 : $revision->Changed;
                }
                
            }

            // Init validation result
            $out_data = new ValidationResult(new stdClass());
            $out_data->Add("Result", $submission);
            
            // Return data
            return $out_data->toJSON();
        }
	};
?>