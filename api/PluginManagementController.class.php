<?php
session_start();

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);

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
    const INSTALLP = "INSTALLP";
    const INSTALLC = "INSTALLC";
    const COMPONENTS = "COMPONENTS";
    
    /**
     * Install plugin
     * @param mixed $plugin 
     * @return mixed
     */
    public function Install($plugin)    {
        return FactoryService::PluginManagementService()->Install($plugin);
    }
    
    /**
     * Get list of all plugins
     * @return list of plugins
     */
    public function Uninstalled() {
        return FactoryService::PluginManagementService()->GetNotInstalledPlugins();
    }
    
    /**
     * Get list of all components
     */
    public function Components()    {
        return FactoryService::ComponentService()->GetComponents();
    }
    
    /**
     * Install component
     */
    public function InstallComponent($component)    {
        return FactoryService::ComponentService()->Install($component);
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

        case PluginManagementController::INSTALLP:
            $result = $PluginManagementController->Install($data);
            break;
            
        case PluginManagementController::COMPONENTS:
            $result = $PluginManagementController->Components();
            break;
            
        case PluginManagementController::INSTALLC:
            $result = $PluginManagementController->InstallComponent($data);
            break;
            
		default:
			$result = false;
			break;
	}

	// Return answer to client
	exit(json_encode($result));
}