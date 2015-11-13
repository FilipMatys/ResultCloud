<?php
session_start();

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);
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
    const RECENT = "RECENT";

    /**
     * Get recent submissions
     * @return mixed $submissions
     */
    public function Recent()    {
        // Load recent submissions
        return FactoryService::SubmissionService()->GetRecent();
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
        case SubmissionController::RECENT:
            $result = $SubmissionController->Recent();
            break;
        
		default:
			$result = false;
			break;
	}
    
	// Return answer to client
	exit(json_encode($result));
}
