<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::CORLY_DAO_IMPLEMENTATION_PLUGIN);
Library::using(Library::CORLY_SERVICE_SUITE);
Library::using(Library::CORLY_ENTITIES);
Library::using(Library::UTILITIES);

/**
 * ProjectService short summary.
 *
 * ProjectService description.
 *
 * @version 1.0
 * @author Filip
 */
class ProjectService
{
    // Daos
    private $ProjectDao;
    
    private $SubmissionService;
    
    /**
     * Project service constructor
     */
    public function __construct()   {
        $this->ProjectDao = new ProjectDao();
        $this->SubmissionService = new SubmissionService();
    }
    
    /**
     * Get filtered list of projects
     * @param Parameter $parameter 
     * @return filtered list of projects
     */
    public function GetFilteredList(Parameter $parameter)   {
        return $this->ProjectDao->GetFilteredList($parameter);
    }
    
    /**
     * Get list of projects
     * @return list of projects
     */
    public function GetList()   {
        return $this->ProjectDao->GetList();
    }
    
    /**
     * Save project
     * @param mixed $project 
     */
    public function Save($project)  {
        // Initialize validation
        $validation = new ValidationResult($project);
        
        // Set date created if creating new
        if (!isset($project->Id))   {
            $project->DateCreated = date("c");
        }
        
        // Save project
        $this->ProjectDao->Save($project);
        
        // Return validation
        return$validation;
    }
    
    /**
     * Load project with all submissions
     * @param mixed $project 
     * @return mixed
     */
    public function GetDetail($project) {
        // Load project from database
        $dbProject = $this->ProjectDao->Load($project);
        
        // Map database object to TSE object
        $project = new ProjectTSE();
        $project->MapDbObject($dbProject);
        
        // Load submissions and add them to project
        foreach ($this->SubmissionService->LoadSubmissions($dbProject->Id) as $submission)
        {
            // Add submission to project
            $project->AddSubmission($submission);
        }
        
        // Return project
        return $project;
    }
}
