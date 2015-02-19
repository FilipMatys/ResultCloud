<?php
session_start();

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);

class UserController	{
	// Request constants
	const SAVE = "SAVE";
	const GET = "GET";
	const QUERY = "QUERY";
    const CURRENT = "CURRENT";

	// Save item
	public function Save($user)	{
		return FactoryService::UserService()->Save($user);
	}

	// Get item detail
	public function Get($user)	{
		return FactoryService::UserService()->GetDetail($user);
	}

	// Get all items
	public function Query()	{
		return FactoryService::UserService()->GetDetailedList();
	}
    
    /**
     * Get current user
     * @return mixed
     */
    public function Current()   {
        return FactoryService::UserService()->GetCurrent();
    }
}

// Extract json data
$rawData = file_get_contents('php://input');
$data = json_decode($rawData);

// Check GET requests
if (isset($_GET["method"]))	{
	// Init result
	$result = new stdClass();
	$UserController = new UserController();

	switch ($_GET["method"]) {
		case UserController::SAVE:
			$result = $UserController->Save($data);
			break;
		
		case UserController::GET:
			$result = $UserController->Get($data);
			break;

		case UserController::QUERY:
			$result = $UserController->Query();
			break;

        case UserController::CURRENT:
            $result = $UserController->Current();
            break;
            
		default:
			$result = false;
			break;
	}

	// Return answer to client
	exit(json_encode($result));
}