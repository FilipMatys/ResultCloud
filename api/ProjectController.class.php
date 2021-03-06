<?php
session_start();

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::UTILITIES, ['QueryParameter.php']);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);

/**
 * ProjectController short summary.
 *
 * ProjectController description.
 *
 * @version 1.0
 * @author Filip
 */
class ProjectController
{
    // Method constants
    const QUERY = "QUERY";
    const PLUGIN = "PLUGIN";
    const GET = "GET";
    const SAVE = "SAVE";
    const CLEAR = "CLEAR";
    const DELETE = "DELETE";
    const DELETE_SUBMISSION = "DELETE_SUBMISSION";
    
    /**
     * Save given project
     * @param mixed $project 
     * @return mixed
     */
    public function Save($project)  {
        return FactoryService::ProjectService()->Save($project);
    }
    
    /**
     * Get list of projects
     * @param mixed $pluginId
     * @return list of projects of given plugin
     */
    public function Plugin($pluginId)    {
        return FactoryService::ProjectService()->GetFilteredList(QueryParameter::Where('Plugin', $pluginId))->ToList();
    }
    
    /**
     * Get list of projects
     * @return mixed
     */
    public function Query() {
        return FactoryService::ProjectService()->GetList()->ToList();
    }
    
    /**
     * Clear given project
     * @param mixed $projecId 
     * @return mixed
     */
    public function Clear($projectId)    {
        // Initialize object
        $project = new stdClass();
        $project->Id = $projectId;
        
        // Load views
        return FactoryService::ProjectService()->ClearProject($project);
    }

    /**
     * Delete given project
     * @param mixed $projecId 
     * @return mixed
     */
    public function Delete($projectId)    {
        // Initialize object
        $project = new stdClass();
        $project->Id = $projectId;
        
        // Load views
        return FactoryService::ProjectService()->DeleteProject($project);
    }
    
    /**
     * Get project 
     * @param mixed $projectId 
     * @return mixed
     */
    public function Get($request) {
        $project = new stdClass();
        $project->Id = $request->ItemId;
        // Get project detail
        return FactoryService::ProjectService()->GetDetail($project, $request->Type);
    }

    /**
     * Delete given submission
     * @param mixed $projecId 
     * @return mixed
     */
    public function DeleteSubmission($Ids)    {
        // Initialize object
        $submission = new stdClass();
        $submission->Id = $Ids->submissionId;
        $submission->projectId = $Ids->projectId;

        
        // Load views
        return FactoryService::SubmissionService()->DeleteSubmission($submission);
    }
}

// Extract json data
$rawData = file_get_contents('php://input');
$data = json_decode($rawData);

// Check GET requests
if (isset($_GET["method"]))	{
	// Init result
	$result = new stdClass();
	$ProjectController = new ProjectController();

	switch ($_GET["method"]) {
		case ProjectController::SAVE:
			$result = $ProjectController->Save($data);
			break;

        case ProjectController::PLUGIN:
            $result = $ProjectController->Plugin($data);
            break;
            
        case ProjectController::QUERY:
            $result = $ProjectController->Query();
            break;
            
        case ProjectController::GET:
            $result = $ProjectController->Get($data);
            break;
            
        case ProjectController::CLEAR:
            $result = $ProjectController->Clear($data);
            break;
        case ProjectController::DELETE:
            $result = $ProjectController->Delete($data);
            break;
        case ProjectController::DELETE_SUBMISSION:
            $result = $ProjectController->DeleteSubmission($data);
            break;

		default:
			$result = false;
			break;
	}
    
	// Return answer to client
	exit(json_encode($result));
}
