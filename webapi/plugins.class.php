<?php
	/**
	 * Class for get plugins details with API
	 * @author Bohdan Iakymets
	 */
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');
	
	// Include files
	Library::using(Library::CORLY_SERVICE_PLUGIN);
	Library::using(Library::UTILITIES);


	class plugins {
		// Get plugins method
		public function get($params) {
			$plugin_service = new PluginService();
			$data = new ValidationResult(new stdClass());
			$data->Add("Result", $plugin_service->GetList()->ToList());
			//Start authorization
			return $data->toJSON();
		}

		public function getProjects($params) {
			// Init parametrs
			$data = new stdClass();
			$data->Plugin = $params['plugin'];
			$project_service = new ProjectService();

			error_log(json_encode($project_service->GetFilteredList(QueryParameter::Where('Plugin', $data->Plugin))->ToList()));

			$out_data = new ValidationResult(new stdClass());
			$out_data->Add("Result", $project_service->GetFilteredList(QueryParameter::Where('Plugin', $data->Plugin))->ToList());

			//Start authorization
			return $out_data->toJSON();
		}
	};
?>