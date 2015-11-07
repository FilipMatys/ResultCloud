<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_SERVICE_SESSION);
Library::using(Library::CORLY_SERVICE_UTILITIES);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryDao.class.php']);
Library::usingTools();

/**
 * View service.
 *
 * ViewService.
 *
 * @version 1.0
 * @author Filip
 */
class ViewService
{
    /**
     * Get views for selected project and view type
     * @param mixed $request
     * @return ValidationResult
     */
    public function GetViews($request)  {
        // Init validation
        $validation = new ValidationResult($request);

        // Validate request
        $validation->CheckNotNullOrEmpty("Project", "Project not set for component");
        $validation->CheckNotNullOrEmpty("View", "View type not set");

        // Check validation
        if (!$validation->IsValid)  {
            return $validation;
        }

        // Load components
        $validation->Data = FactoryService::ComponentService()->GetListForViewByProject($request->Project, $request->View);
        
        // Return result
        return $validation;
    }

    /**
     * Visualize given component
     * @param mixed $request
     * @return ValidationResult
     */
    public function Visualize($request) {
        // End session to allow other requests
        SessionService::CloseSession();

        // Init validation
        $validation = new ValidationResult($request);

        // Validate request
        $validation->CheckNotNullOrEmpty("Source", "Source not set for component");
        $validation->CheckNotNullOrEmpty("Identifier", "Identifier not set");

        // Check validation
        if (!$validation->IsValid)  {
            return $validation;
        }

        // Get component
        $component = FactoryService::ComponentService()->GetByIdentifier($request->Identifier);
        
        // Check if component was loaded
        if (is_null($component))    {
            $validation->AddError("Component not found");
            return $validation;
        }
        
        // Load component
        FactoryService::ComponentService()->LoadComponent($component);

        // Check validation
        if (!$validation->IsValid)  {
            return $validation;
        }

        // Prepare data
        $data = new stdClass();
        $data->Metadata = $request->Metadata;

        // Load proper TSE entity
        switch ($component->ViewType)   {
            case ViewType::SUBMISSION:
                // Load data
                $data->SubmissionTSE = FactoryService::SubmissionService()->LoadTSE($request->Source);
                $data->SubmissionTSE->SetProject(FactoryService::ProjectService()->LoadTSE($data->SubmissionTSE->GetProject()));
                $data->SubmissionTSE->GetProject()->SetPlugin(FactoryService::PluginService()->LoadTSE($data->SubmissionTSE->GetProject()->GetPlugin()));
                break;
            case ViewType::DIFFERENCE:
                $data->Submissions = $this->LoadDataForDifferenceView($request->Source);
                break;
            case ViewType::PROJECT:
                // Load data
                $data->ProjectTSE = FactoryService::ProjectService()->LoadTSE($request->Source);
                $data->ProjectTSE->SetPlugin(FactoryService::PluginService()->LoadTSE($data->ProjectTSE->GetPlugin()));
                break;
            default:
                $validation->AddError('Invalid view type');
                return $validation;
        }
        
        // Get component data
        return CBuilder::Get($data);
    }
    
    /**
     * Load submissions for difference view
     */
    private function LoadDataForDifferenceView($data) {
        // Get submission ids
        $submissionIds = explode("&", $data->Submissions);
        
        // Initialize array for submissions
        $submissions = array();
        foreach ($submissionIds as $submissionId) {
            // Init object
            $submission = new stdClass();
            $submission->Id = $submissionId;
            // Add object to array
            $submissions[] = FactoryService::SubmissionService()->LoadTSE($submission);
        }
        
        // Return resulted array
        return $submissions;
    }
}

