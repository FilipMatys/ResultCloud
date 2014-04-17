<?php
session_start();

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_SERVICE_PLUGIN);
Library::using(Library::UTILITIES);

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
    
    // Services
    private $ProjectService;
    
    /**
     * Project controller constructor
     */
    public function __construct()   {
        $this->ProjectService = new ProjectService();
    }
    
    /**
     * Save given project
     * @param mixed $project 
     * @return mixed
     */
    public function Save($project)  {
        return $this->ProjectService->Save($project);
    }
    
    /**
     * Get list of projects
     * @param mixed $pluginId
     * @return list of projects of given plugin
     */
    public function Plugin($pluginId)    {
        return $this->ProjectService->GetFilteredList(QueryParameter::Where('Plugin', $pluginId));
    }
    
    /**
     * Get list of projects
     * @return mixed
     */
    public function Query() {
        return $this->ProjectService->GetList();
    }
    
    /**
     * Get project 
     * @param mixed $projectId 
     * @return mixed
     */
    public function Get($projectId) {
        $project = new stdClass();
        $project->Id = $projectId;
        // Get project detail
        return $this->ProjectService->GetDetail($project);
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
            
		default:
			$result = false;
			break;
	}
    
	// Return answer to client
	exit(json_encode($result));
}
