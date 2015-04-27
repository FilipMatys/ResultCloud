<?php
session_start();

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);

class UpdateController	{
	// Request constants
    const CHECK = "CHECK";
    
    /**
     * Check if application version is current and update it
     * @return mixed
     */
    public function Check() {
        return FactoryService::UpdateService()->CheckDB();
    }
    
}

// Extract json data
$rawData = file_get_contents('php://input');
$data = json_decode($rawData);

// Check GET requests
if (isset($_GET["method"]))	{
	// Init result
	$result = new stdClass();
	$UpdateController = new UpdateController();

	switch ($_GET["method"]) {
            
        case UpdateController::CHECK:
            $result = $UpdateController->Check();
            break;
            
		default:
			$result = false;
			break;
	}

	// Return answer to client
	exit(json_encode($result));
}