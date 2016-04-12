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
    public function Save(&$submission, $projectId)    {
        // Init validation
        $validation = $this->ValidateSubmission($submission, $projectId);
        
        // Check validation result
        if (!$validation->IsValid)
            return $validation;
        
        // Get git repo sequence number if it has git hash
        if ($submission->GetGitHash() != "")    
            $submission->SetSequenceNumber($this->GetGitRepoSequenceNumber($submission, $projectId));

        // Save submission
        $submissionId = FactoryDao::SubmissionDao()->Save($submission->GetDbObject($projectId));
        $submission->setId($submissionId);
        
        // Save categories with test cases
        FactoryService::CategoryService()->SaveCategories($submission->GetCategories(), $submissionId);

        // Do all possible extensions
        $dbSubmission = new Submission($submissionId);
        $submissionTSE = $this->LoadTSE($dbSubmission);

        // Summary extension
        SummaryController::Summarize($submissionTSE);
        
        // Return validation
        return $validation;
    }

    
    /**
     * Get filtered list of submissions
     */
    public function GetGitRepoSequenceNumber(SubmissionTSE $submissionTSE, $projectId)
    {
        // Load project, so we get to know the repo path and other submissions
        $project = new Project($projectId);
        $dbProject = FactoryDao::ProjectDao()->Load($project);

        // Get all submissions for project
        $lSubmissions = $this->GetFilteredList(QueryParameter::Where('Project', $project->Id));

        // If list has no submission, set the number to one and save it
        if ($lSubmissions->IsEmpty())   {
            // There is no need to handle anything else
            return 1;
        }

        // Load repository to find the right sequence number
        $repository = GitService::Open(basename($dbProject->GitRepository));
        // Update the repository to the latest version
        $repository->remote_update();

        // Iterate through submissions to find the right sequence number
        $incrementSequenceNumber = false;
        $sequenceNumber = 0;
        foreach ($lSubmissions->OrderByNumber('SequenceNumber')->ToList() as $submission)
        {
            // We are in state of updating all other submissions sequence numbers
            if ($incrementSequenceNumber)   {
                $submission->SequenceNumber = $submission->SequenceNumber + 1;

                // Save the updated submission
                FactoryDao::SubmissionDao()->Save($submission);

                // Get to another submission
                continue;
            }

            // We found the first commit, that is not an ancestor
        	if (($repository->is_ancestor($submission->GitHash, $submissionTSE->GetGitHash())) != 0)  {
                $sequenceNumber = $submission->SequenceNumber;

                // Update sequence number of the submission we found is not an ancestor
                $submission->SequenceNumber = $submission->SequenceNumber + 1;
                // Save the updated submission
                FactoryDao::SubmissionDao()->Save($submission);

                // Set state to just update sequence numbers
                $incrementSequenceNumber = true;
            }
        }

        // Check if we found any commits, that are not ancestors, if not, set it to be the last
        if ($sequenceNumber == 0)   {
            $sequenceNumber = $lSubmissions->Count() + 1;
        }

        // Return sequence number for new submission
        return $sequenceNumber;
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
    public function LoadSubmissions(&$projectTSE, $depth, $queryPagination = null)   {
        // Load submissions for given project
        $lSubmissions = FactoryDao::SubmissionDao()->GetFilteredList(QueryParameter::Where('Project', $projectTSE->GetId()), $queryPagination);
        
        error_log("One: ".$lSubmissions->GetTotalCount());
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
        
            FactoryService::AnalyzerService()->ClearBySubmission($dbSubmission->Id);
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