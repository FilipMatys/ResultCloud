<?php
session_start();

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_INSTALLATION);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);

class InstallationController	{
	// Request constants
	const INSTALL = "INSTALL";
    const CHECK = "CHECK";
    const REGISTER = "REGISTER";
    
	/**
	 * Install application
	 * @param mixed $data 
	 * @return mixed
	 */
	public function Install($data)	{
		return FactoryService::InstallationService()->Install($data);
	}
    
    /**
     * Check if application is installed
     * @return mixed
     */
    public function Check() {
        return FactoryService::InstallationService()->CheckInstallation();
    }
    
    /**
     * Register user
     * @param mixed $user 
     * @return mixed
     */
    public function Register($user) {
        return FactoryService::InstallationService()->RegisterUser($user);
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
            
        case InstallationController::CHECK:
            $result = $InstallationController->Check();
            break;

        case InstallationController::REGISTER:
            $result = $InstallationController->Register($data);
            break;
            
		default:
			$result = false;
			break;
	}

	// Return answer to client
	exit(json_encode($result));
}