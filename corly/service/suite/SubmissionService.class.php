<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_SUITE);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_PLUGIN);
Library::using(Library::CORLY_SERVICE_SUITE);
Library::using(Library::CORLY_SERVICE_PLUGIN);


/**
 * SubmissionService short summary.
 *
 * SubmissionService description.
 *
 * @version 1.0
 * @author Filip
 */
class SubmissionService
{
    private $SubmissionDao;
    private $ProjectDao;

    private $CategoryService;
    private $PluginService;
    
    /**
     * Initialize class daos and services
     */
    public function __construct()   {
        $this->SubmissionDao = new SubmissionDao();
        $this->ProjectDao = new ProjectDao();
        
        $this->CategoryService = new CategoryService();
        $this->PluginService = new PluginService();
    }
    

    /**
     * Save summary as a whole, which means 
     * save all appended objects as well
     * @param mixed $submission 
     * @param mixed $projectId 
     * @return validation
     */
    public function Save($submission, $projectId)    {
        // Init validation
        $validation = $this->ValidateSubmission($submission);
        
        // Save submission
        $submissionId = $this->SubmissionDao->Save($submission->GetDbObject($projectId));
        
        // Save categories with test cases
        $this->CategoryService->SaveCategories($submission->GetCategories(), $submissionId);
        
        // Return validation
        return $validation;
    }
        
    /**
     * Get submission detail for visualization
     * @param mixed $submission 
     * @return mixed
     */
    public function GetDetail($submission)    {
        // Load submission from database
        $dbSubbmission = $this->SubmissionDao->Load($submission);
        
        // Map database object to TSE object
        $submission = new SubmissionTSE();
        $submission->MapDbObject($dbSubbmission);
        
        // Initialize validation
        $validation = new ValidationResult($submission);
        
        // Get to the plugin, so the right one is used
        // Initialize project object
        $dbProject = new stdClass();
        $dbProject->Id = $dbSubbmission->Project;
        // Load project
        $dbProject = $this->ProjectDao->Load($dbProject);
        
        // Load plugin execution
        $this->PluginService->LoadPlugin($dbProject->Plugin);
        
        // Check if visualizer was included
        if (!class_exists('Visualization'))  {
            $validation->AddError("Visualization for given plugin was not found");
            return $validation;
        }
        
        // Load categories for submission
        foreach ($this->CategoryService->LoadCategories($dbSubbmission->Id) as $category)   {
            $submission->AddCategory($category);
        }
        
        // Process data by plugin
        $validation = Visualization::VisualizeSubmission($submission);
        
        // Return result
        return $validation;
    }
    
    /**
     * Load all submissions for given project
     * @param mixed $projectId 
     * @return mixed
     */
    public function LoadSubmissions($projectId)   {
        // Load submissions for given project
        $dbSubmissions = $this->SubmissionDao->GetFilteredList(QueryParameter::Where('Project', $projectId));
        
        // Init submission array
        $submissions = array();
        
        // Map submissions to TSE objects and load categories
        foreach ($dbSubmissions as $dbSubmission)
        {
            $submission = new SubmissionTSE();
            $submission->MapDbObject($dbSubmission);
            
            // Load categories
            foreach ($this->CategoryService->LoadCategories($dbSubmission->Id) as $category)
            {
                // Add category to submission
                $submission->AddCategory($category);
            }
            
            // Add submission to array
            $submissions[] = $submission;
        }
        
        // Return submissions
        return $submissions;
    }
    
    /**
     * Validate submission data
     */
    private function ValidateSubmission($data)   {
        // Initialize validation 
        $validation = new ValidationResult($data);
        
        // Check if there are any data
        $validation->CheckDataNotNull("Invalid data supplied");
        
        // Check validation result
        if (!$validation->IsValid)  {
            return $validation;
        }
        
        return $validation;
    }
    
}