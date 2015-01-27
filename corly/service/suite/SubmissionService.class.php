<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_SUITE);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_PLUGIN);
Library::using(Library::CORLY_SERVICE_SUITE);
Library::using(Library::CORLY_SERVICE_PLUGIN);
Library::using(Library::CORLY_SERVICE_SECURITY);
Library::using(Library::CORLY_SERVICE_SESSION);


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
    private $UserService;
    
    /**
     * Initialize class daos and services
     */
    public function __construct()   {
        $this->SubmissionDao = new SubmissionDao();
        $this->ProjectDao = new ProjectDao();
        
        $this->CategoryService = new CategoryService();
        $this->PluginService = new PluginService();
        $this->UserService = new UserService();
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
        $validation = $this->ValidateSubmission($submission, $projectId);
        
        // Check validation result
        if (!$validation->IsValid)
            return $validation;
        
        // Save submission
        $submissionId = $this->SubmissionDao->Save($submission->GetDbObject($projectId));
        
        // Save categories with test cases
        $this->CategoryService->SaveCategories($submission->GetCategories(), $submissionId);
        
        // Return validation
        return $validation;
    }
    
    /**
     * Get difference of given submissions 
     * @param mixed $submissions 
     * @return mixed
     */
    public function Difference($submissions, $project, $type, $meta)    {
        // Initialize validation
        $validation = new ValidationResult($submissions);
        
        // Load plugin execution
        $dbProject = $this->ProjectDao->Load($project);
        $this->PluginService->LoadPlugin($dbProject->Plugin);
        
        // Check if visualizer was included
        if (!class_exists('Visualization'))  {
            $validation->AddError("Visualization for given plugin was not found");
            return $validation;
        }
        
        // Close session so other requests are allowed
        SessionService::CloseSession();
        
        // Get view depth
        $depth = Visualization::GetDifferenceDataDepth($type);
        
        // Create array of submissions to pass to visualizer
        $tseSubmissions = array();
        foreach ($submissions as $submission)   {
            // Load submission
            $dbSubmission = $this->SubmissionDao->Load($submission);
            
            // Create new TSE entity
            $tseSubmission = new SubmissionTSE();
            $tseSubmission->MapDbObject($dbSubmission);
            
            // Load user if set
            if ($dbSubmission->User != 0)   {
                $user = new stdClass();
                $user->Id = $dbSubmission->User;
                // Load from database
                $user = $this->UserService->GetDetail($user);
                // Assign to submission
                $tseSubmission->SetUser($user);
            }
            
            // Load categories into submission
            $this->CategoryService->LoadCategories($tseSubmission, $depth - 1);
            
            // Add submission to list
            $tseSubmissions[] = $tseSubmission;
        }
        
        // Visualize difference
        $validation = Visualization::VisualizeDifference($tseSubmissions, $type, $meta);
        
        // Return validation result with data
        return $validation;
    }
    
    /**
     * Get view components for given submission
     * @param mixed $submission 
     * @return mixed
     */
    public function GetViews($submission)   {
        // Load submission from database
        $dbSubbmission = $this->SubmissionDao->Load($submission);
        
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
        
        // Process data by plugin
        $validation = Visualization::GetSubmissionViewComponents();
        
        // Return result
        return $validation;
    }
        
    /**
     * Get submission detail for visualization
     * @param mixed $submission 
     * @return mixed
     */
    public function GetDetail($submission, $type,  $meta = null)    {
        // Load submission from database
        $dbSubbmission = $this->SubmissionDao->Load($submission);
        
        // Map database object to TSE object
        $submission = new SubmissionTSE();
        $submission->MapDbObject($dbSubbmission);
        
        // Load user if set
        if ($dbSubmission->User != 0)   {
            $user = new stdClass();
            $user->Id = $dbSubmission->User;
            // Load from database
            $user = $this->UserService->GetDetail($user);
            // Assign to submission
            $submission->SetUser($user);
        }
        
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
        
        // Close session so other requests are allowed
        SessionService::CloseSession();
        
        // Get view depth
        $depth = Visualization::GetSubmissionDataDepth($type);
        
        // Load categories for submission
        $this->CategoryService->LoadCategories($submission, $depth - 1);
        
        // Process data by plugin
        $validation = Visualization::VisualizeSubmission($submission, $type, $meta);
        
        // Return result
        return $validation;
    }

    /**
     * Get filtered list of submissions
     */
    public function GetFilteredList(Parameter $parameter)   {
        return $this->SubmissionDao->GetFilteredList($parameter);
    }
    
    /**
     * Load all submissions for given project
     * @param mixed $projectId
     * @param mixed $depth
     * @return mixed
     */
    public function LoadSubmissions($projectTSE, $depth)   {
        // Load submissions for given project
        $dbSubmissions = $this->SubmissionDao->GetFilteredList(QueryParameter::Where('Project', $projectTSE->GetId()))->ToList();
        
        // Map submissions to TSE objects and load categories
        foreach ($dbSubmissions as $dbSubmission)
        {
            $submission = new SubmissionTSE();
            $submission->MapDbObject($dbSubmission);
            
            // Load user if set
            if ($dbSubmission->User != 0)   {
                $user = new stdClass();
                $user->Id = $dbSubmission->User;
                // Load from database
                $user = $this->UserService->GetDetail($user);
                // Assign to submission
                $submission->SetUser($user);
            }
            
            // Load categories if not reached the depth
            if ($depth > 0) {
                $this->CategoryService->LoadCategories($submission, $depth - 1);
            }
            
            // Add submission to project
            $projectTSE->AddSubmission($submission);
        }
    }
    
    /**
     * Validate submission data
     * @param mixed $data 
     * @param mixed $projectId 
     * @return mixed
     */
    private function ValidateSubmission(SubmissionTSE $data, $projectId)   {
        // Initialize validation 
        $validation = new ValidationResult($data);
        
        // Check if there are any data
        $validation->CheckDataNotNull("Invalid data supplied");
        
        // Get all submissions of given project
        $lSubmissions = $this->SubmissionDao->GetFilteredList(QueryParameter::Where('Project', $projectId));
        
        // Check if submission is in list
        if (in_array($data->GetDateTime(), $lSubmissions->Select('DateTime')->ToList())) {
            $validation->AddError("Submission was already imported");
        }
        
        // Check validation result
        if (!$validation->IsValid)  {
            return $validation;
        }
        
        return $validation;
    }
    
}