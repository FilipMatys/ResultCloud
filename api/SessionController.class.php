<?php
session_start();

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);

/**
 * SessionController short summary.
 *
 * SessionController description.
 *
 * @version 1.0
 * @author Filip
 */
class SessionController {
    // Request constants
	const CHECK = "CHECK";

	// Authorize credentials
	public function Check()	{
		return FactoryService::SessionService()->IsSessionSet('id');
	}
}

// Extract json data
$rawData = file_get_contents('php://input');
$data = json_decode($rawData);

// Check GET requests
if (isset($_GET["method"]))	{
	// Init result
	$result = new stdClass();
	$SessionController = new SessionController();

	switch ($_GET["method"]) {
		case SessionController::CHECK:
			$result = $SessionController->Check();
			break;
		
		default:
			$result = false;
			break;
	}

	// Return answer to client
	exit(json_encode($result));
}
