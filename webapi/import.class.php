<?php
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

	//include files
	Library::using(Library::CORLY_DAO_IMPLEMENTATION_PLUGIN, ['ImportSessionDao.php']);
	Library::using(Library::CORLY_SERVICE_IMPORT);
	Library::using(Library::CORLY_DAO_IMPLEMENTATION_SECURITY, ['TokenDao.class.php']);
	Library::using(Library::UTILITIES, ['QueryParameter.php', 'LINQ.php', 'ValidationResult.php']);

	class import {

		// Propertie with path to 'temp' folder
		private $TEMP_FOLDER = '';

		// Constructor
		public function __construct() {
			$this->TEMP_FOLDER = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'temp';
		}

		/**
		 * Method for upload and import files to server
		 * @param  array $params 
		 * @return ValidationResult
		 */
		public function upload($params) {

			$import_service = new ImportService();
			$data = new stdClass();

			//	Check if set import session id
			if (isset($_GET['sessionid'])) {

				// Get parametres
				$data->SessionId = $_GET['sessionid']; 
				$data->Part = $_GET['part'];

				// Check valid of import session
				$validation = $this->CheckSession($data);

				// Check parametr
				$validation->CheckNotNullOrEmpty('Part', "Part of imported file has to be set");

				if (!$validation->IsValid)
					return $validation->toJSON();

				// Check if file was uploaded
				if (!isset($_FILES['file'])) {
        	    	$validation->AddError("No file selected");
            		return $validation->toJSON();
        		}

        		// Check if 'temp' folder doesn't exist
        		if (!is_dir($this->TEMP_FOLDER))
        			mkdir($this->TEMP_FOLDER);

        		// Working with uploaded file
        		$filename = $this->TEMP_FOLDER.DIRECTORY_SEPARATOR.$data->SessionId.'.'.$data->Part.'.tmp';
        		move_uploaded_file($_FILES['file']['tmp_name'], $filename);

        		return $validation->toJSON();
			}
			// Init parametrs
			$data->Project = $_GET['project'];
			$data->Plugin = $_GET['plugin'];
			$data->Token = $_GET['token_key'];

			//Check token
			$validation = $this->CheckToken($data);

			if (!$validation->IsValid)
				return $validation->toJSON();

			// Check if file was selected
    	    if (!isset($_FILES['file']) && !isset($_GET['sessionid'])) {
        	    $validation->AddError("No file selected");
            	return $validation->toJSON();
        	}

        	$data->Id = $validation->Data->Id;

        	// Import and return results of import
			return $import_service->Import($data, $_FILES['file'], true)->toJSON();
		}

		/**
		 * Start import session
		 * @param  array $params
		 * @return ValidationResult
		 */
		public function start($params) {
			// Check token
			$data = new stdClass();
			$data->Token = $_GET['token_key'];
			$validation = $this->CheckToken($data);

			if (!$validation->IsValid)
				return $validation->toJSON();

			$sessioncreator = new ImportSessionDao();

			// Delete all import sessions older than 24h
			$sessioncreator->DeleteFilteredList(QueryParameter::WhereLess('CreationTime', (time()-(24*60*60))));

			// Preparation parametrs for saving in DB
			$sessionData = new stdClass();
			$sessionData->Project = $_GET['project'];
			$sessionData->Plugin = $_GET['plugin'];
			$sessionData->User = $validation->Data->Id;
			$sessionData->CreationTime = time();
			$sessionData->SessionId = uniqid('', true);

			// Save
			$sessioncreator->Save($sessionData);

			$validation->Add("Result", $sessionData);

			// Return validation results
			return $validation->toJSON();
		}

		/**
		 * End import session
		 * @param  array $params
		 * @return ValidationResult
		 */
		public function end($params) {
			// Check import session id
			$data->SessionId = $_GET['sessionid']; 
			$validation = $this->CheckSession($data);

			if (!$validation->IsValid)
				return $validation->toJSON();

			// Find parts of file
			$temp_files = glob($this->TEMP_FOLDER.DIRECTORY_SEPARATOR.$data->SessionId.".*.tmp");

			// If not found
			if (empty($temp_files)) {
				$validation->AddError("Not found any file part");
				return $validation->toJSON();
			}

			natsort($temp_files);

			// Join parts
			foreach ($temp_files as $file) {
				$file_content = file_get_contents($file);
				file_put_contents($this->TEMP_FOLDER.DIRECTORY_SEPARATOR.$data->SessionId.'.tmp', $file_content, FILE_APPEND);
				unlink($file);
			}

			// Start import service
			$import_service = new ImportService();

			$file_info = array();
			$file_info['tmp_name'] = $this->TEMP_FOLDER.DIRECTORY_SEPARATOR.$data->SessionId.'.tmp';

			// Import and delete temp file
			$result = $import_service->Import($validation->Data, $file_info, true)->toJSON();
			//unlink($file_info['tmp_name']);

			return $result;
		}

		/**
		 * Check token valid
		 * @param mixed $data 
		 */
		private function CheckToken($data) {
			$validation = new ValidationResult($data);

    		$validation->CheckNotNullOrEmpty('Token', "Token has to be set");

        	if (!$validation->IsValid)
        		return $validation;

        	$TokenDao = new TokenDao();
        	$tokens = $TokenDao->GetFilteredList(QueryParameter::Where('TokenKey', $data->Token));

        	//	Check if token exist in DB
        	if ($tokens->IsEmpty()) {
        		$validation->AddError("Wrong Token");
        		return $validation;
        	}

        	// Check creation time of token
        	if (($tokens->Single()->CreationTime + (24*60*60)) < time()) {
        		$validation->AddError("Token time out");
        		// Delete if older than 24h
        		$TokenDao->DeleteFilteredList(QueryParameter::Where('TokenKey', $data->Token));
        		return $validation;
        	}

        	$validation->Data->Id = $tokens->Single()->User;

        	// Return result
        	return $validation;
		}

		/**
		 * Check import session
		 * @param mixed $data
		 */
		private function CheckSession($data) {
			$validation = new ValidationResult($data);

			$validation->CheckNotNullOrEmpty('SessionId', "Session id has to be set");

			if (!$validation->IsValid)
        		return $validation;

        	$sessioncreator = new ImportSessionDao();

        	$sessions = $sessioncreator->GetFilteredList(QueryParameter::Where('SessionId', $data->SessionId));

        	// If import session id exist
        	if ($sessions->IsEmpty()) {
        		$validation->AddError("Wrong Session Id");
        		return $validation;
        	}

        	// Check creation time
        	if (($sessions->Single()->CreationTime + (24*60*60)) < time()) {
        		$validation->AddError("Token time out");
        		$sessioncreator->DeleteFilteredList(QueryParameter::Where('SessionId', $data->SessionId));
        		return $validation;
        	}

        	// Session information
        	$validation->Data->Plugin = $sessions->Single()->Plugin;
        	$validation->Data->Project = $sessions->Single()->Project;
        	$validation->Data->Id = $sessions->Single()->User;

        	// Return results
        	return $validation;
		}
	}
?>