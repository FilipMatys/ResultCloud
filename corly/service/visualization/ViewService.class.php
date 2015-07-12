<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_SERVICE_SESSION);
Library::using(Library::CORLY_SERVICE_UTILITIES);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryDao.class.php']);
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

        // Load plugin
        $validation->Append($this->LoadPlugin($request->Project));
        // Check validation
        if (!$validation->IsValid)  {
            return $validation;
        }

        // Return result
        return Visualization::GetViewComponents($request->View);
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
        $validation->CheckNotNullOrEmpty("Project", "Project not set for component");
        $validation->CheckNotNullOrEmpty("View", "View type not set");
        $validation->CheckNotNullOrEmpty("Type", "Component type not set");

        // Check validation
        if (!$validation->IsValid)  {
            return $validation;
        }

        // Load plugin
        $validation->Append($this->LoadPlugin($request->Project));

        // Check validation
        if (!$validation->IsValid)  {
            return $validation;
        }

        // Return result
        $projectTSE = new ProjectTSE();
        $projectTSE->MapDbObject(FactoryDao::ProjectDao()->Load($request->Project));
        $request->Project = $projectTSE;
        return Visualization::Visualize($request);
    }

    /**
     * Summary of LoadPlugin
     * @param mixed $project
     * @return ValidationResult
     */
    private function LoadPlugin($project) {
        // End session to allow other requests
        SessionService::CloseSession();

        // Init validation
        $validation = new ValidationResult($project);

        // Validate
        $validation->CheckDataNotNull("Project not set");
        $validation->CheckNotNullOrEmpty("Id", "Unknown project requested");

        // Check validation
        if (!$validation->IsValid)
            return $validation;

        // Load project from database
        $dbProject = FactoryDao::ProjectDao()->Load($project);
        // Load plugin
        FactoryService::PluginService()->LoadPlugin($dbProject->Plugin);
        // Check if visualization class exists
        if (!class_exists('Visualization')) {
            $validation->AddError("Project does not support visualization");
            return $validation;
        }

        // Return validation
        return $validation;
    }
}
