<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_SERVICE_SESSION);
Library::using(Library::EXTENTIONS_SUMMARIZERS); 
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

        // Do the summarization
        $dbSubmission = new stdClass();
        $dbSubmission->Id = $submissionId;
        SummaryController::Summarize($this->LoadTSE($dbSubmission));
        
        // Return validation
        return $validation;
    }
    
    
    /**
     * Get filtered list of submissions
     */
    public function GetFilteredList(Parameter $parameter)   {
        return FactoryDao::SubmissionDao()->GetFilteredList($parameter);
    }

    /**
     * Get recent submissions
     */
    public function GetRecent() {
        // Get last five submissions (use workaround for query parameter)
        $lSubmissions = FactoryDao::SubmissionDao()->GetFilteredList(QueryParameter::WhereNot('Project', 0), 
            new QueryPagination(1, 5, 'desc'));

        // Init result
        $submissions = array();

        // Load author and project for each submission
        foreach ($lSubmissions->ToList() as $dbSubmission) {

            // Load user if set
            if ($dbSubmission->User != 0)   {
                $user = new stdClass();
                $user->Id = $dbSubmission->User;
                // Assign to submission
                $dbSubmission->User = FactoryService::UserService()->GetDetail($user);
            }

            // Load project
            $project = new stdClass();
            $project->Id = $dbSubmission->Project;
            $dbSubmission->Project = FactoryDao::ProjectDao()->Load($project);

            // Add submission to array
            $submissions[] = $dbSubmission;
        }

        // Return result
        return $submissions;
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
        
        // Check for duplicate, if saving new
        if ($data->GetId() == 0)   {
            // Get all submissions of given project
            $lSubmissions = FactoryDao::SubmissionDao()->GetFilteredList(QueryParameter::Where('Project', $projectId));

            // Check if submission is in list
            if (in_array($data->GetDateTime(), $lSubmissions->Select('DateTime')->ToList())) {
                $validation->AddError("Submission was already imported");
            }
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
            //Load plugin and delete its configuration
            $project = new stdClass();
            $project->Id = $projectId;
            $dbProject = FactoryDao::ProjectDao()->Load($project);
            FactoryService::PluginService()->LoadPlugin($dbProject->Plugin);
            // Check if visualizer was included
            if (!class_exists('PluginServices'))  {
                $validation->AddError("PluginService for given plugin was not found");
                return $validation;
            }
        
            PluginServices::DeleteSubmission($dbSubmission);
        }
        FactoryDao::SubmissionDao()->DeleteFilteredList(QueryParameter::Where('Project', $projectId));
    }

    /**
     * Load submission as TSE
     */
    public function LoadTSE($submission)   {
        // Prepare entity
        $submissionTSE = new SubmissionTSE();
    
        // Load submission
        $submissionTSE->MapDbObject(FactoryDao::SubmissionDao()->Load($submission));
    
        // Return result
        return $submissionTSE;
    }

    /**
     * Delete submission
     * @param submission to be deleted
     * @return Validation result 
     */
    public function DeleteSubmission($submission) {
        // Init validation
        $validation = new ValidationResult($submission);

        // Check data
        $validation->CheckDataNotNull("Submission not set");
        $validation->CheckNotNullOrEmpty("Id", "Submission identifier not set");
        $validation->CheckNotNullOrEmpty("projectId", "Project identifier not set");

        // Check validation
        if (!$validation->IsValid)
            return $validation;

        //Get plugin
        $project = new stdClass();
        $project->Id = $submission->projectId;
        $dbProject = FactoryDao::ProjectDao()->Load($project);
        FactoryService::PluginService()->LoadPlugin($dbProject->Plugin);

        $sub_info = FactoryDao::SubmissionDao()->Load($submission);

        // Check if visualizer was included
        if (!class_exists('PluginServices'))  {
            $validation->AddError("PluginService for given plugin was not found");
            return $validation;
        }
        
        $validation->Append(PluginServices::DeleteSubmission($sub_info));
        // Return validation
        return $validation;
    }
}