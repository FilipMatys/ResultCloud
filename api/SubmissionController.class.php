<?php
session_start();

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_SERVICE_SUITE);
Library::using(Library::UTILITIES);

/**
 * SubmissionController short summary.
 *
 * SubmissionController description.
 *
 * @version 1.0
 * @author Filip
 */
class SubmissionController
{
    // Method constants
    const GET = "GET";
    const DIFFERENCE = "DIFFERENCE";
    const VIEWS = "VIEWS";
    
    // Services
    private $SubmissionService;
    
    /**
     * Project controller constructor
     */
    public function __construct()   {
        $this->SubmissionService = new SubmissionService();
    }
    
    /**
     * Get project 
     * @param mixed $projectId 
     * @return mixed
     */
    public function Get($request) {
        $submission = new stdClass();
        $submission->Id = $request->ItemId;
        // Get project detail
        return $this->SubmissionService->GetDetail($submission, $request->Type, $request->Meta);
    }
    
    /**
     * Get difference
     * @param mixed $data 
     * @return mixed
     */
    public function Difference($request)   {
        // Get submission ids
        $submissionIds = explode("&", $request->Submissions);
        
        // Initialize array for submissions
        $submissions = array();
        foreach ($submissionIds as $submissionId) {
            // Init object
            $submission = new stdClass();
            $submission->Id = $submissionId;
            // Add object to array
            $submissions[] = $submission;
        }
        
        // Prepare project
        $project = new stdClass();
        $project->Id = $request->Project;
        
        // Get result
        return $this->SubmissionService->Difference($submissions, $project, $request->Type, $request->Meta);
    }
    
    /**
     * Get views for submission
     * @param mixed $submissionId 
     * @return mixed
     */
    public function Views($submissionId) {
        // Initialize object
        $submission = new stdClass();
        $submission->Id = $submissionId;
        
        // Load views
        return $this->SubmissionService->GetViews($submission);
    }
}

// Extract json data
$rawData = file_get_contents('php://input');
$data = json_decode($rawData);

// Check GET requests
if (isset($_GET["method"]))	{
	// Init result
	$result = new stdClass();
	$SubmissionController = new SubmissionController();

	switch ($_GET["method"]) {
        case SubmissionController::GET:
            $result = $SubmissionController->Get($data);
            break;
            
        case SubmissionController::DIFFERENCE:
            $result = $SubmissionController->Difference($data);
            break;
            
        case SubmissionController::VIEWS:
            $result = $SubmissionController->Views($data);
            break;
        
		default:
			$result = false;
			break;
	}
    
	// Return answer to client
	exit(json_encode($result));
}
