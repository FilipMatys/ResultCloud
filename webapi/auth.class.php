<?php
	/**
	 * Class for authorization with API
	 * @author Bohdan Iakymets
	 */
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');
	
	// Include files
	Library::using(Library::CORLY_SERVICE_SECURITY);

	class auth {
		// Login method
		public function login($params) {
			// Init parametrs
			$data = new stdClass();
			$data->Username = $params['username'];
			$data->Password = $params['password'];
			$auth_service = new AuthentizationService();

			//Start authorization
			return $auth_service->Authorize($data, true)->toJSON();
		}
	};
?>