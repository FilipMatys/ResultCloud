<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryDao.class.php']);

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
    /**
     * Get list of all plugins
     * @return list of plugins
     */
    public function GetList()   {
        return FactoryDao::PluginDao()->GetList();
    }
    
    /**
     * Summary of GetFilteredList
     * @param QueryParameter $queryParameter 
     * @return Filtered list of plugins
     */
    public function GetFilteredList(Parameter $parameter)   {
        return FactoryDao::PluginDao()->GetFilteredList($parameter);    
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
        $id = FactoryDao::PluginDao()->Save($plugin);
        
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
        $plugin = FactoryDao::PluginDao()->Load($plugin);

        // Get all projects
        $plugin->Projects = FactoryDao::ProjectDao()->GetFilteredList(QueryParameter::Where('Plugin', $plugin->Id))->ToList();
        foreach ($plugin->Projects as $project) {
            $author = new stdClass();
            $author->Id = $project->Author;
            // Load  author
            $project->Author = FactoryService::UserService()->GetDetail($author);
            
            // Get submissons
            $lSubmissions = FactoryDao::SubmissionDao()->GetFilteredList(QueryParameter::Where('Project', $project->Id));
            // Set submissions count
            $project->Submissions = $lSubmissions->Count();
        }
    
        // Return final plugin object
        return $plugin;
    }

    /**
     * Get liveness for plugin
     * @param mixed $plugin
     * @return plugin with liveness
     */
    public function GetLiveness($plugin)    {
        // Create google chart for each project
        foreach ($plugin->Projects as $project) {
            // Get chart
            $project = FactoryService::ProjectService()->GetLiveness($project);
        }

        // Return result
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
        $plugin = FactoryDao::PluginDao()->Load($plugin);
        
        // Load plugin structure
        Library::using(Library::PLUGINS .DIRECTORY_SEPARATOR. $plugin->Root);
    }
}

