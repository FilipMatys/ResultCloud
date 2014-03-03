<?php
session_start();

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::SERVICE_SECURITY);

class AuthentizationController	{
	// Request constants
	const AUTHORIZE = "AUTHORIZE";

	// Service
	private $AuthentizationService;

	// Constructor
	public function __construct()	{
		$this->AuthentizationService = new AuthentizationService();
	}

	// Authorize credentials
	public function Authorize($credentials)	{
		return $this->AuthentizationService->Authorize($credentials);
	}
}

// Extract json data
$rawData = file_get_contents('php://input');
$data = json_decode($rawData);

// Check GET requests
if (isset($_GET["method"]))	{
	// Init result
	$result = new stdClass();
	$AuthentizationController = new AuthentizationController();

	switch ($_GET["method"]) {
		case AuthentizationController::AUTHORIZE:
			$result = $AuthentizationController->Authorize($data);
			break;
		
		default:
			$result = false;
			break;
	}

	// Return answer to client
	exit(json_encode($result));
}