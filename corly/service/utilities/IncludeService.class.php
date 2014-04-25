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
    const PLUGINS_PATH = "plugins";
    const PLUGIN_COMPONENTS = "components";
    const JS = "js";
    
    // Types
    const TYPE_JAVASCRIPT = "text/javascript";
    
    /**
     * Load js components
     */
    public static function JsComponents()   {
        // Get all components
        foreach (IncludeService::LoadComponents() as $component)    {
            IncludeService::OutputJsComponent($component);
        }
        
    }
    
    /**
     * Load components
     * @return mixed
     */
    private static function LoadComponents()  {
        // Initialize dao
        $componentDao = IncludeService::InitComponetDao();
        $pluginDao = IncludeService::InitPluginDao();
        
        // Load components
        $components = $componentDao->GetList();
        // Load plugin for each component
        foreach ($components as $component) {
            // Init plugin object
            $plugin = new stdClass();
            $plugin->Id = $component->Plugin;
            
            // Load plugin to component
            $component->Plugin = $pluginDao->Load($plugin);
        }
        
        // Return result
        return $components;
    }
    
    /**
     * Get path to plugin components folder
     * @param mixed $pluginRoot 
     * @return mixed
     */
    private static function GetPathToComponents($pluginRoot)    {
        return IncludeService::PLUGINS_PATH . DIRECTORY_SEPARATOR . $pluginRoot . DIRECTORY_SEPARATOR . IncludeService::PLUGIN_COMPONENTS;
    }
    
    /**
     * Evaluate path to component
     * @param mixed $component 
     * @return mixed
     */
    private static function EvaluatePathToComponent($component)   {
        return IncludeService::GetPathToComponents($component->Plugin->Root) . DIRECTORY_SEPARATOR . $component->Folder . DIRECTORY_SEPARATOR . IncludeService::JS . DIRECTORY_SEPARATOR . $component->Filename;
    }
    
    /**
     * Output js component
     * @param mixed $component 
     */
    private static function OutputJsComponent($component) {
        echo IncludeService::GetScriptElement(IncludeService::EvaluatePathToComponent($component), IncludeService::TYPE_JAVASCRIPT);
    }
    
    /**
     * Get script element as string
     * @param mixed $src 
     * @param mixed $type 
     * @return mixed
     */
    private static function GetScriptElement($src, $type)   {
        return '<script src="'.$src.'" type="'.$type.'"></script>';
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
