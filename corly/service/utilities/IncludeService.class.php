<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::CORLY_DAO_IMPLEMENTATION_PLUGIN);
Library::using(Library::UTILITIES);

/**
 * IncludeService short summary.
 *
 * IncludeService description.
 *
 * @version 1.0
 * @author Filip
 */
class IncludeService
{
    /**
     * Load js components
     */
    public static function JsComponents()   {
        // Initialize dao
        $componentDao = IncludeService::InitComponetDao();
        $pluginDao = IncludeService::InitPluginDao();
        
        // Get all components
    }
    
    /**
     * Get component dao initialization
     * @return mixed
     */
    private static function InitComponetDao()   {
        return new ComponentDao();   
    }
    
    /**
     * Get plugin dao initialization
     * @return mixed
     */
    private static function InitPluginDao() {
        return new PluginDao();
    }
}
