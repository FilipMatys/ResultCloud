<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_SERVICE_SESSION);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryDao.class.php']);


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
        $submissionId = FactoryDao::SubmissionDao()->Save($submission->GetDbObject($projectId));
        
        // Save categories with test cases
        FactoryService::CategoryService()->SaveCategories($submission->GetCategories(), $submissionId);
        
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
        $dbProject = FactoryDao::ProjectDao()->Load($project);
        FactoryService::PluginService()->LoadPlugin($dbProject->Plugin);
        
        // Check if visualizer was included
        if (!class_exists('Visualization'))  {
            $validation->AddError("Visualization for given plugin was not found");
            return $validation;
        }
        
        // Close session so other requests are allowed
        SessionService::CloseSession();
        
        // Create array of submissions to pass to visualizer
        $tseSubmissions = array();
        foreach ($submissions as $submission)   {
            // Load submission
            $dbSubmission = FactoryDao::SubmissionDao()->Load($submission);
            
            // Create new TSE entity
            $tseSubmission = new SubmissionTSE();
            $tseSubmission->MapDbObject($dbSubmission);
            
            // Load user if set
            if ($dbSubmission->User != 0)   {
                $user = new stdClass();
                $user->Id = $dbSubmission->User;
                // Load from database
                $user = FactoryService::UserService()->GetDetail($user);
                // Assign to submission
                $tseSubmission->SetUser($user);
            }
            
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
        $dbSubbmission = FactoryDao::SubmissionDao()->Load($submission);
        
        // Initialize validation
        $validation = new ValidationResult($submission);
        
        // Get to the plugin, so the right one is used
        // Initialize project object
        $dbProject = new stdClass();
        $dbProject->Id = $dbSubbmission->Project;
        // Load project
        $dbProject = FactoryDao::ProjectDao()->Load($dbProject);
        
        // Load plugin execution
        FactoryService::PluginService()->LoadPlugin($dbProject->Plugin);
        
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
        $dbSubbmission = FactoryDao::SubmissionDao()->Load($submission);
        
        // Map database object to TSE object
        $submission = new SubmissionTSE();
        $submission->MapDbObject($dbSubbmission);
        
        // Load user if set
        if ($dbSubmission->User != 0)   {
            $user = new stdClass();
            $user->Id = $dbSubmission->User;
            // Load from database
            $user = FactoryService::UserService()->GetDetail($user);
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
        $dbProject = FactoryDao::ProjectDao()->Load($dbProject);
        
        // Load plugin execution
        FactoryService::PluginService()->LoadPlugin($dbProject->Plugin);
        
        // Check if visualizer was included
        if (!class_exists('Visualization'))  {
            $validation->AddError("Visualization for given plugin was not found");
            return $validation;
        }
        
        // Close session so other requests are allowed
        SessionService::CloseSession();
        
        // Process data by plugin
        $validation = Visualization::VisualizeSubmission($submission, $type, $meta);
        
        // Return result
        return $validation;
    }

    /**
     * Get filtered list of submissions
     */
    public function GetFilteredList(Parameter $parameter)   {
        return FactoryDao::SubmissionDao()->GetFilteredList($parameter);
    }
    
    /**
     * Load all submissions for given project
     * @param mixed $projectId
     * @param mixed $depth
     * @return mixed
     */
    public function LoadSubmissions($projectTSE, $depth, $queryPagination = null)   {
        // Load submissions for given project
        $lSubmissions = FactoryDao::SubmissionDao()->GetFilteredList(QueryParameter::Where('Project', $projectTSE->GetId()), $queryPagination);
        
        // Map submissions to TSE objects and load categories
        foreach ($lSubmissions->ToList() as $dbSubmission)
        {
            $submission = new SubmissionTSE();
            $submission->MapDbObject($dbSubmission);
            
            // Load user if set
            if ($dbSubmission->User != 0)   {
                $user = new stdClass();
                $user->Id = $dbSubmission->User;
                // Load from database
                $user = FactoryService::UserService()->GetDetail($user);
                // Assign to submission
                $submission->SetUser($user);
            }
            
            // Load categories if not reached the depth
            if ($depth > 0) {
                FactoryService::CategoryService()->LoadCategories($submission, $depth - 1);
            }
            
            // Add submission to project
            $projectTSE->AddSubmission($submission);
        }

        // Set pagination values
        $projectTSE->SetPage($lSubmissions->GetPage());
        $projectTSE->SetTotalCount($lSubmissions->GetTotalCount());
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
        $lSubmissions = FactoryDao::SubmissionDao()->GetFilteredList(QueryParameter::Where('Project', $projectId));
        
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
    
    /**
     * Clear submission
     * @param projectId
     */
    public function ClearSubmission($projectId) {
        $dbSubmissions = FactoryDao::SubmissionDao()->GetFilteredList(QueryParameter::Where('Project', $projectId))->ToList();
        foreach ($dbSubmissions as $dbSubmission)
        {
            FactoryService::CategoryService()->ClearCategory($dbSubmission->Id);
        }
        FactoryDao::SubmissionDao()->DeleteFilteredList(QueryParameter::Where('Project', $projectId));
    }
}