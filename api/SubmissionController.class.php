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
    public function Get($submissionId) {
        $submission = new stdClass();
        $submission->Id = $submissionId;
        // Get project detail
        return $this->SubmissionService->GetDetail($submission);
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
        
		default:
			$result = false;
			break;
	}
    
	// Return answer to client
	exit(json_encode($result));
}
