<?php
session_start();

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_SERVICE_SECURITY);
Library::using(Library::UTILITIES, ['ValidationResult.php']);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);

class AuthentizationController	{
	// Request constants
	const AUTHORIZE = "AUTHORIZE";
    const DEAUTHORIZE = "DEAUTHORIZE";

	/**
	 * Authorize credentials
	 * @param mixed $credentials 
	 * @return mixed
	 */
	public function Authorize($credentials)	{
		return FactoryService::AuthentizationService()->Authorize($credentials);
	}
    
    /**
     * Deauthorize current user
     * @return mixed
     */
    public function Deauthorize()   {
        return FactoryService::AuthentizationService()->Deauthorize();
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
            
        case AuthentizationController::DEAUTHORIZE:
            $result = $AuthentizationController->Deauthorize();
            break;
		
		default:
			$result = new ResultManager();
			break;
	}

	// Return answer to client
	exit(json_encode($result));
}