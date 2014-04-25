<?php
session_start();

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_SERVICE_PLUGIN);

/**
 * PluginManagementController short summary.
 *
 * PluginManagementController description.
 *
 * @version 1.0
 * @author Filip
 */
class PluginManagementController
{
    // Method constants
    const UNINSTALLED = "UNINSTALLED";
    const INSTALL = "INSTALL";
    
    // Controller service
    private $PluginManagementService;
    
    /**
     * Plugin management controller constructor
     */
    public function __construct()  {
        $this->PluginManagementService = new PluginManagementService();
    }
    
    /**
     * Install plugin
     * @param mixed $plugin 
     * @return mixed
     */
    public function Install($plugin)    {
        return $this->PluginManagementService->Install($plugin);
    }
    
    /**
     * Get list of all plugins
     * @return list of plugins
     */
    public function Uninstalled() {
        return $this->PluginManagementService->GetNotInstalledPlugins();
    }
}

// Extract json data
$rawData = file_get_contents('php://input');
$data = json_decode($rawData);

// Check GET requests
if (isset($_GET["method"]))	{
	// Init result
	$result = new stdClass();
	$PluginManagementController = new PluginManagementController();

	switch ($_GET["method"]) {
		case PluginManagementController::UNINSTALLED:
			$result = $PluginManagementController->Uninstalled();
			break;

        case PluginManagementController::INSTALL:
            $result = $PluginManagementController->Install($data);
            break;
            
		default:
			$result = false;
			break;
	}

	// Return answer to client
	exit(json_encode($result));
}