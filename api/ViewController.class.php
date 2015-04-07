<?php
session_start();

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_SERVICE_SECURITY);
Library::using(Library::UTILITIES, ['ValidationResult.php']);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);

/**
 * View controller.
 *
 * @version 1.0
 * @author Filip
 */
class ViewController
{
    const VISUALIZE = "VISUALIZE";
    const VIEWS = "VIEWS";

    /**
     * Visualize component
     * @param mixed $request
     * @return mixed
     */
    public function Visualize($request) {
        return FactoryService::ViewService()->Visualize($request);
    }

    /**
     * Get views for given type of view
     * @param mixed $request
     * @return mixed
     */
    public function GetViews($request)  {
        return FactoryService::ViewService()->GetViews($request);
    }
}

// Extract json data
$rawData = file_get_contents('php://input');
$data = json_decode($rawData);

// Check GET requests
if (isset($_GET["method"]))	{
	// Init result
	$result = new stdClass();
	$ViewController = new ViewController();

	switch ($_GET["method"]) {
		case ViewController::VISUALIZE:
			$result = $ViewController->Visualize($data);
			break;

        case ViewController::VIEWS:
            $result = $ViewController->GetViews($data);
            break;

		default:
			$result = false;
			break;
	}

	// Return answer to client
	exit(json_encode($result));
}
