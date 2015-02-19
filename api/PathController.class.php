<?php
session_start();

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);

/**
 * PathController short summary.
 *
 * PathController description.
 *
 * @version 1.0
 * @author Filip
 */
class PathController
{
    const PATH = "PATH";
    
    /**
     * Get path to given entity
     * @param mixed $data 
     * @return mixed
     */
    public function GetPath($data)  {
        $entity = new stdClass();
        $entity->Id = $data->EntityId;
        
        // Get path
        return FactoryService::PathService()->GetPath($data->Type, $entity);
    }
}

// Extract json data
$rawData = file_get_contents('php://input');
$data = json_decode($rawData);

// Check GET requests
if (isset($_GET["method"]))	{
	// Init result
	$result = new stdClass();
	$PathController = new PathController();

	switch ($_GET["method"]) {
		case PathController::PATH:
			$result = $PathController->GetPath($data);
			break;

		default:
			$result = false;
			break;
	}

	// Return answer to client
	exit(json_encode($result));
}