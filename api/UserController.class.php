<?php
session_start();

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_SERVICE_SECURITY);

class UserController	{
	// Request constants
	const SAVE = "SAVE";
	const GET = "GET";
	const QUERY = "QUERY";
    const CURRENT = "CURRENT";

	// Service
	private $UserService;

	// Constructor
	public function __construct()	{
		$this->UserService = new UserService();
	}

	// Save item
	public function Save($user)	{
		return $this->UserService->Save($user);
	}

	// Get item detail
	public function Get($user)	{
		return $this->UserService->GetDetail($user);
	}

	// Get all items
	public function Query()	{
		return $this->UserService->GetDetailedList();
	}
    
    /**
     * Get current user
     * @return mixed
     */
    public function Current()   {
        return $this->UserService->GetCurrent();
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