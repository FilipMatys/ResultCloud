<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::CORLY_DAO_IMPLEMENTATION_PLUGIN);
Library::using(Library::UTILITIES);

/**
 * PluginService short summary.
 *
 * PluginService description.
 *
 * @version 1.0
 * @author Filip
 */
class PluginService
{
    // Daos
    private $PluginDao;
    private $ProjectDao;
    
    /**
     * Plugin service constructor
     */
    public function __construct()   {
        $this->PluginDao = new PluginDao();
        $this->ProjectDao = new ProjectDao();
    }
    
    /**
     * Get list of all plugins
     * @return list of plugins
     */
    public function GetList()   {
        return $this->PluginDao->GetList();
    }
    
    /**
     * Summary of GetFilteredList
     * @param QueryParameter $queryParameter 
     * @return Filtered list of plugins
     */
    public function GetFilteredList(Parameter $parameter)   {
        return $this->PluginDao->GetFilteredList($parameter);    
    }
    
    /**
     * Get detail of plugin
     * @param mixed $plugin 
     * @return plugin with projects
     */
    public function GetDetail($plugin)  {
        // Load plugin from base table
        $plugin = $this->PluginDao->Load($plugin);

        // Get all projects
        $plugin->Projects = $this->ProjectDao->GetFilteredList(QueryParameter::Where('Plugin', $plugin->Id));
    
        // Return final plugin object
        return $plugin;
    }
}

