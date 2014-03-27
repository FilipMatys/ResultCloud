<?php
session_start();

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_INSTALLATION);
Library::using(Library::CORLY_SERVICE_INSTALLATION);

class InstallationController	{
	// Request constants
	const INSTALL = "INSTALL";
    
	// Service
	private $InstallationService;

	// Constructor
	public function __construct()	{
		$this->InstallationService = new InstallationService();
	}

	// Install application
	public function Install($data)	{
		return $this->InstallationService->Install($data);
	}
}

// Extract json data
$rawData = file_get_contents('php://input');
$data = json_decode($rawData);

// Check GET requests
if (isset($_GET["method"]))	{
	// Init result
	$result = new stdClass();
	$InstallationController = new InstallationController();

	switch ($_GET["method"]) {
		case InstallationController::INSTALL:
			$result = $InstallationController->Install($data);
			break;

		default:
			$result = false;
			break;
	}

	// Return answer to client
	exit(json_encode($result));
}