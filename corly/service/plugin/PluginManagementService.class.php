<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_PLUGIN);
Library::using(Library::CORLY_ENTITIES);

/**
 * PluginManagementService short summary.
 *
 * PluginManagementService description.
 *
 * @version 1.0
 * @author Filip
 */
class PluginManagementService
{
    const CONFIG_FILE = "config.xml";
    
    private $PluginDao;
    
    private $PluginService;
    
    /**
     * Plugin management service constructor
     */
    public function __construct()   {
        $this->PluginDao = new PluginDao();
        $this->PluginService = new PluginService();
    }
    
    /**
     * Install plugin
     * @param mixed $plugin 
     * @return mixed
     */
    public function Install($plugin)    {
        $pluginTSE = new PluginTSE();
        $pluginTSE->MapObject($plugin);
        // Initialize validation
        $validation = new ValidationResult($pluginTSE);
        
        // Save plugin
        $this->PluginService->Save($pluginTSE->GetDbObject());
        
        // Return validation
        return $validation;
    }
    
    /**
     * Get all not installed plugins
     * @return mixed
     */
    public function GetNotInstalledPlugins()  {
        // Get plugin folders
        $pluginDirectoryNames = $this->GetPluginFolders();
        // Get installed plugins and their folders
        $lInstalledPlugins = new LINQ($this->GetInstalledPlugins());
        $installedPluginsDirNames = $lInstalledPlugins->Select('Root')->ToList();
        
        // Load configuration for each not installed plugin
        $uninstalledPlugins = array();
        foreach ($pluginDirectoryNames as $pluginDirname) {
            // If plugin is installed, go to another
            if (in_array($pluginDirname, $installedPluginsDirNames))
                continue;
            
            // Get plugin configuration
            $pluginConfiguration = $this->GetPluginConfiguration($pluginDirname);
            
            // Create plugin entity
            $plugin = new PluginTSE((string)$pluginConfiguration->base->name);
            // Set values
            $plugin->SetVersion((string)$pluginConfiguration->base->version);
            $plugin->SetAuthor((string)$pluginConfiguration->base->author);
            $plugin->SetAbout((string)$pluginConfiguration->base->about);
            $plugin->SetRoot((string)$pluginConfiguration->base->root);
            
            // Add plugin to array
            $uninstalledPlugins[] = $plugin->ExportObject();
        }
        
        // Return result
        return $uninstalledPlugins;
    }
    
    /**
     * Get all folders from plugin folder
     * @return mixed
     */
    private function GetPluginFolders() {
        $pluginDirectoryNames = array();
        foreach (glob(Library::path(Library::PLUGINS, "*"), GLOB_ONLYDIR) as $folder)   {
            $pluginDirectoryNames[] = basename($folder);   
        }
        return $pluginDirectoryNames;
    }
    
    /**
     * Get all installed plugins
     * @return mixed
     */
    private function GetInstalledPlugins()   {
        return $this->PluginDao->GetList();
    }
    
    private function GetPluginConfiguration($basename)   {
        // Load XML configuration
        return simplexml_load_file(Library::path(Library::PLUGINS . DIRECTORY_SEPARATOR . $basename, PluginManagementService::CONFIG_FILE));
    }
}
