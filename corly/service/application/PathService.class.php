<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_DAO_STAT);
Library::using(Library::CORLY_DAO_APPLICATION);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_PLUGIN);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_SUITE);

/**
 * PathService short summary.
 *
 * PathService description.
 *
 * @version 1.0
 * @author Filip
 */
class PathService
{
    private $PluginDao;
    private $ProjectDao;
    private $SubmissionDao;
    
    /**
     * Dao initializators
     */
    public function __construct()   {
        $this->PluginDao = new PluginDao();
        $this->ProjectDao = new ProjectDao();
        $this->SubmissionDao = new SubmissionDao();
    }
    
    /**
     * Get path to entity
     * @param mixed $type 
     * @param mixed $entity 
     * @return mixed
     */
    public function GetPath($type, $entity) {
        // Check path type
        switch($type)   {
            // Submission
            case PathType::SUBMISSION:
                return $this->GetPathToSubmission($entity);
            
            // Difference
            case PathType::DIFFERENCE:
                return $this->GetPathToDifference($entity);
                
            // Project
            case PathType::PROJECT:
                return $this->GetPathToProject($entity);
                
            default:
                return null;
        }
    }
    
    /**
     * Get path to project
     * @param mixed $entity 
     * @return mixed
     */
    private function GetPathToProject($entity)   {
        return $this->GetPathToDifference($entity);
    }
    
    /**
     * Get Path To Submission
     * @param mixed $entity 
     * @return mixed
     */
    private function GetPathToSubmission($entity)   {
        // Init path
        $path = new Path();
        
        // Load submission
        $path->Submission = $this->SubmissionDao->Load($entity);
        
        // Init project
        $project = new stdClass();
        $project->Id = $path->Submission->Project;
        
        // Load project
        $path->Project = $this->ProjectDao->Load($project);
        
        // Init plugin
        $plugin = new stdClass();
        $plugin->Id = $path->Project->Plugin;
        
        // Load plugin
        $path->Plugin = $this->PluginDao->Load($plugin);
        
        // Return path        
        return $path;
    }
    
    /**
     * Get path to difference
     * @param mixed $entity 
     * @return mixed
     */
    private function GetPathToDifference($entity)   {
        // Init path
        $path = new Path();
        
        // Load project
        $path->Project = $this->ProjectDao->Load($entity);
        
        // Init plugin
        $plugin = new stdClass();
        $plugin->Id = $path->Project->Plugin;
        
        // Load plugin
        $path->Plugin = $this->PluginDao->Load($plugin);
        
        // Return path        
        return $path;
    }
}
