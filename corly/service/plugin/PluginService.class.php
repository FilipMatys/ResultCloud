<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::CORLY_DAO_IMPLEMENTATION_PLUGIN);
Library::using(Library::CORLY_SERVICE_SECURITY);
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
    private $SubmissionDao;
    
    private $UserService;
    
    /**
     * Plugin service constructor
     */
    public function __construct()   {
        $this->PluginDao = new PluginDao();
        $this->ProjectDao = new ProjectDao();
        $this->SubmissionDao = new SubmissionDao();
        
        $this->UserService = new UserService();
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
     * Save plugin
     * @param mixed $plugin 
     * @return mixed
     */
    public function Save($plugin)   {
        // Initialie validation
        $validation = new ValidationResult($plugin);
        
        // Save plugin
        $id = $this->PluginDao->Save($plugin);
        
        // Set id for validation result
        if ($id != 0)
            $validation->Data->Id = $id;
        
        // Return validation
        return $validation;
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
        foreach ($plugin->Projects as $project) {
            $author = new stdClass();
            $author->Id = $project->Author;
            // Load  author
            $project->Author = $this->UserService->GetDetail($author);
            
            // Get submissons
            $lSubmissions = new LINQ($this->SubmissionDao->GetFilteredList(QueryParameter::Where('Project', $project->Id)));
            // Set submissions count
            $project->Submissions = $lSubmissions->Count();
        }
    
        // Return final plugin object
        return $plugin;
    }
    
    /**
     * Get given plugin to import data
     */
    public function LoadPlugin($pluginId)  {
        // Prepare plugin object to load
        $plugin = new stdClass();
        $plugin->Id = $pluginId;
        
        // Load plugin 
        $plugin = $this->PluginDao->Load($plugin);
        
        // Load plugin structure
        Library::using(Library::PLUGINS .DIRECTORY_SEPARATOR. $plugin->Root);
    }
}

