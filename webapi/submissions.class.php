<?php
	/**
	 * Class to get submission details with API
	 * @author Filip Matys
	 */
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');
	
	// Include files
    Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryDao.class.php']);
	Library::using(Library::UTILITIES);


	class submissions {
        // Get projects
		public function getList($params) {
            // Load submissions for given project
            $submissions = FactoryDao::SubmissionDao()->GetFilteredList(QueryParameter::Where('Project', $params['project']))->ToList();

            $out_data = new ValidationResult(new stdClass());
            $out_data->Add("Result", $submissions);

			// Return data
			return $out_data->toJSON();
		}

        public function getByHash($params)    {
            $data = new stdClass();
            $data->GitHash = $params['hash'];

            $submission = FactoryDao::SubmissionDao()->GetFilteredList(QueryParameter::Where('GitHash', $data->GitHash))->Single();

            // Init validation result
            $out_data = new ValidationResult(new stdClass());
            $out_data->Add("Result", $submission);
            
            // Return data
            return $out_data->toJSON();
        }
	};
?>