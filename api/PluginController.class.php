<?php
session_start();

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);

/**
 * PluginController short summary.
 *
 * PluginController description.
 *
 * @version 1.0
 * @author Filip
 */
class PluginController
{
    // Method constants
    const QUERY = "QUERY";
    const GET = "GET";
    const GET_L = "GET_L";
    const QUERY_L = "QUERY_L";

    /**
     * Get plugin with liveness
     * @param mixed $pluginId
     * @return plugin with detail with liveness
     */
    public function GetWithLiveness($pluginId) {
        return FactoryService::PluginService()->GetLiveness($this->Get($pluginId));
    }
    
    /**
     * Get detail of given plugin
     * @param mixed $pluginId 
     * @return plugin with detail
     */
    public function Get($pluginId)  {
        // Create new plugin entity
        $plugin = new stdClass();
        $plugin->Id = $pluginId;
        
        // Return result
        return FactoryService::PluginService()->GetDetail($plugin);
    }
    
    /**
     * Get list of all plugins
     * @return list of plugins
     */
    public function Query() {
        return FactoryService::PluginService()->GetList()->ToList();
    }

    /**
     * Get list of all plugins with projects
     */
    public function QueryWithLiveness() {
        // Initialize plugins array
        $plugins = array();

        // For each plugin, get all projects
        foreach ($this->Query() as $plugin) {
            $plugins[] = $this->GetWithLiveness($plugin->Id);
        }

        // Return result
        return $plugins;
    }
}

// Extract json data
$rawData = file_get_contents('php://input');
$data = json_decode($rawData);

// Check GET requests
if (isset($_GET["method"]))	{
	// Init result
	$result = new stdClass();
	$PluginController = new PluginController();

	switch ($_GET["method"]) {
		case PluginController::GET:
			$result = $PluginController->Get($data);
			break;

		case PluginController::QUERY:
			$result = $PluginController->Query();
			break;

        case PluginController::GET_L:
            $result = $PluginController->GetWithLiveness($data);
            break;

        case PluginController::QUERY_L:
            $result = $PluginController->QueryWithLiveness();
            break;

		default:
			$result = false;
			break;
	}

	// Return answer to client
	exit(json_encode($result));
}