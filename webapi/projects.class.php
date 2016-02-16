<?php
	/**
	 * Class to get project details with API
	 * @author Bohdan Iakymets
	 */
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');
	
	// Include files
	Library::using(Library::CORLY_SERVICE_PLUGIN);
    Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);
	Library::using(Library::UTILITIES);


	class projects {
        // Get projects
		public function getList($params) {
			// Init parametrs
			$data = new stdClass();
			$data->Plugin = $params['plugin'];
			$project_service = new ProjectService();

            // Get projects for given plugin
            if (isset($data->Plugin)) {
                error_log(json_encode($project_service->GetFilteredList(QueryParameter::Where('Plugin', $data->Plugin))->ToList()));

                $out_data = new ValidationResult(new stdClass());
                $out_data->Add("Result", $project_service->GetFilteredList(QueryParameter::Where('Plugin', $data->Plugin))->ToList());
            }
            // Get all projects
            else {
                error_log(json_encode($project_service->GetList()->ToList()));

                $out_data = new ValidationResult(new stdClass());
                $out_data->Add("Result", $project_service->GetList()->ToList());
            }

			// Return data
			return $out_data->toJSON();
		}

        public function get($params)    {
            $data = new stdClass();
            $data->Id = $params['project'];

            // Load project
            $project = FactoryService::ProjectService()->GetDetail($data);
            // Get submissions
            $project->Submissions = FactoryService::SubmissionService()->GetFilteredList(QueryParameter::Where('Project', $project->Id))->ToList();

            // Init validation result
            $out_data = new ValidationResult(new stdClass());
            $out_data->Add("Result", $project);
            // Return data
            return $out_data->toJSON();
        }

        // Get projects with Git repository
		public function getGitList() {
            // Init service
			$project_service = new ProjectService();
            $plugin_service = new PluginService();

			error_log(json_encode($project_service->GetFilteredList(QueryParameter::WhereNot('GitRepository', ''))->ToList()));

            // Init validation result
			$out_data = new ValidationResult(new stdClass());

            // Get projects
            $projects = $project_service->GetFilteredList(QueryParameter::WhereNot('GitRepository', ''))->ToList();

            // Get plugin for each project
            foreach ($projects as $project)
            {
            	$plugin = new stdClass();
                $plugin->Id = $project->Plugin;

                // Load plugin detail
                $project->Plugin = $plugin_service->GetDetail($plugin);
            }
            
			$out_data->Add("Result", $projects);

			// Return data
			return $out_data->toJSON();
		}
	};
?>