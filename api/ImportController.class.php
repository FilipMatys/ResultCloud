<?php
session_start();

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_SERVICE_IMPORT);

/**
 * ImportController short summary.
 *
 * ImportController description.
 *
 * @version 1.0
 * @author Filip
 */
class ImportController
{
    // Method constants
    const IMPORT = "IMPORT";
    
    // Services
    private $ImportService;
    
    /**
     * Import controller constructor
     */
    public function __construct()   {
        $this->ImportService = new ImportService();
    }
    
    /**
     * Import given data
     */
    public function Import($data)    {
        // Initialize validation
        $validation = new ValidationResult($data);
    
        // Check if file was selected
        if (!isset($_FILES['file'])) {
            $validation->AddError("No file selected");
            return $validation;
        }
        
        // Call import service to import file 
        return $this->ImportService->Import($data, $_FILES['file']);
    }
}

// Extract json data
$rawData = file_get_contents('php://input');
$data = json_decode($rawData);

// Check GET requests
if (isset($_GET["method"]))	{
	// Init result
	$result = new stdClass();
	$ImportController = new ImportController();

	switch ($_GET["method"]) {
		case ImportController::IMPORT:
			$result = $ImportController->Import(json_decode($_POST['data']));
			break;
		
		default:
			$result = false;
			break;
	}

	// Return answer to client
	exit(json_encode($result));
}
