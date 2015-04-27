<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::CORLY_SERVICE_SESSION);
Library::using(Library::CORLY_SERVICE_UTILITIES);
Library::using(Library::CORLY_SERVICE_SETTINGS);
Library::using(Library::CORLY_ENTITIES);
Library::using(Library::UTILITIES);

Library::using(Library::VISUALIZATION_COMPONENT_GOOGLECHART);

Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryDao.class.php']);

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
    /**
     * Get filtered list of projects
     * @param Parameter $parameter 
     * @return filtered list of projects
     */
    public function GetFilteredList(Parameter $parameter)   {
        return FactoryDao::ProjectDao()->GetFilteredList($parameter);
    }
    
    /**
     * Get list of projects
     * @return list of projects
     */
    public function GetList()   {

        return FactoryDao::ProjectDao()->GetList();
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
            $project->DateCreated = TimeService::DateTime();
            $project->Author = SessionService::GetSession('id');
        }
        
        // Save project
        $id = FactoryDao::ProjectDao()->Save($project);

        // Check id, if is zero, new was made
        if ($id != 0)   {
            // Set project id
            $project->Id = $id;

            // Create template settings for project
            $plugin = new stdClass();
            $plugin->Id = $project->Plugin;
            $project->Plugin = FactoryDao::PluginDao()->Load($plugin);
            // Execute
            FactoryService::TemplateSettingsService()->InitProjectSettings($project);
        }

        // Return validation
        return$validation;
    }
    
    /**
     * Get views supported by plugin
     * JFI:Scalable for Project views selection
     * @param mixed $project 
     * @return mixed
     */
    public function GetViews($project)  {
        // Load project from database
        $dbProject = FactoryDao::ProjectDao()->Load($project);
        
        // Load plugin
        FactoryService::PluginService()->LoadPlugin($dbProject->Plugin);
        
        // Initialize validation
        $validation = new ValidationResult($project);
        
        // Check if visualization was included
        if (!class_exists('Visualization'))  {
            $validation->AddError("Visualization for given plugin was not found");
            return $validation;
        }
        
        // Load plugin views
        return Visualization::GetProjectViewComponents();
    }
    
    /**
     * Get difference view components for given submission
     * @param mixed $submission 
     * @return mixed
     */
    public function GetDiffViews($project)   {
        // Load project from database

        $dbProject = FactoryDao::ProjectDao()->Load($project);
        
        // Load plugin

        FactoryService::PluginService()->LoadPlugin($dbProject->Plugin);
        
        // Initialize validation
        $validation = new ValidationResult($project);
        
        // Check if visualization was included
        if (!class_exists('Visualization'))  {
            $validation->AddError("Visualization for given plugin was not found");
            return $validation;
        }
        
        // Process data by plugin
        return Visualization::GetDifferenceViewComponents();
    }
    
    /**
     * Load project with all submissions
     * @param mixed $project 
     * @return mixed
     */
    public function GetDetail($project, $type) {
        // Load project from database

        $dbProject = FactoryDao::ProjectDao()->Load($project);
        
        // Map database object to TSE object
        $project = new ProjectTSE();
        $project->MapDbObject($dbProject);
        
        // Load plugin

        FactoryService::PluginService()->LoadPlugin($dbProject->Plugin);
        
        // Initialize validation
        $validation = new ValidationResult($project);
        
        // Check if visualization was included
        if (!class_exists('Visualization'))  {
            $validation->AddError("Visualization for given plugin was not found");
            return $validation;
        }
        
        // End session to allow other requests
        SessionService::CloseSession();
        

        // Process data by plugin
        return Visualization::VisualizeProject($project, $type);
    }

    /**
     * Clear project
     * @param project to be cleared
     * @return Validation result 
     */
    public function ClearProject($project) {
        // Init validation
        $validation = new ValidationResult($project);

        // Check
        $validation->CheckDataNotNull("Project not set");
        $validation->CheckNotNullOrEmpty("Id", "Project identifier not set");

        // Check validation
        if (!$validation->IsValid)
            return $validation;

        // Load and clear project
        $dbProject = FactoryDao::ProjectDao()->Load($project);
        FactoryService::SubmissionService()->ClearSubmission($dbProject->Id);

        // Return validation
        return $validation;
    }

    /**
     * Delete project
     * @param project to be deleted
     * @return Validation result 
     */
    public function DeleteProject($project) {
        // Init validation
        $validation = new ValidationResult($project);

        // Check
        $validation->CheckDataNotNull("Project not set");
        $validation->CheckNotNullOrEmpty("Id", "Project identifier not set");

        // Check validation
        if (!$validation->IsValid)
            return $validation;

        // Clear submission and delete project
        FactoryService::SubmissionService()->ClearSubmission($project->Id);
        FactoryDao::ProjectDao()->Delete($project);

        // Return validation
        return $validation;
    }

/**
     * Get project liveness
     */
    public function GetLiveness($project)   {
        // Get dates to create liveness for
        $dates = TimeService::MonthIntervalArray(TimeService::Date(), -12);

        // Get submissions of given project
        $submissions = FactoryService::SubmissionService()->GetFilteredList(QueryParameter::Where('Project', $project->Id))->ToList();

        // Initialize chart
        $googleChart = new GoogleChart();
        $googleChart->setType(GCType::COLUMN_CHART);

        // Create options
        $googleChart->setOptions($this->GetLivenessGCOptions());
        $googleChart->setData($this->GetLivenessGCData($submissions, $dates));


        $project->Liveness = $googleChart->ExportObject();
        // Return result
        return $project;
    }

    /**
     * Get data for liveness google chart
     * @param submssions
     * @param dates
     * @return gcData
     */
    private function GetLivenessGCData($submissions, $dates)    {
        // Initialize date
        $gcData = new GCData();
        $lSubmissions = new LINQ($submissions);

        // Set date column
        $gcDateCol = new GCCol();
        $gcDateCol->setId("date");
        $gcDateCol->setLabel("Date");
        $gcDateCol->setType("string");
        // Add column to data set
        $gcData->AddColumn($gcDateCol);

        // Set number column
        $gcCountCol = new GCCol();
        $gcCountCol->setId("count");
        $gcCountCol->setLabel("Count");
        $gcCountCol->setType("number");
        // Add column to data set
        $gcData->AddColumn($gcCountCol);

        foreach ($dates as $date) {
            // Create new row
            $gcRow = new GCRow();
            
            // Create label cell
            $gcLabelCell = new GCCell();
            $gcLabelCell->setValue(substr($date, 0, 7));
            // Add cell to row
            $gcRow->AddCell($gcLabelCell);
            
            // Create value cell
            $gcValueCell = new GCCell();
            $gcValueCell->setValue($lSubmissions->WhereStartsWith('ImportDateTime', substr($date, 0, 7))->Count());
            // Add cell to row
            $gcRow->AddCell($gcValueCell);
            
            // Add row to data
            $gcData->AddRow($gcRow);
        }

        // Return data
        return $gcData;
    }

    /**
     * Get options for liveness google chart
     * @return Google chart options
     */
    private function GetLivenessGCOptions() {
        // Create options and set all in it
        $gcOptions = new GCOptions();
        $gcOptions->setDisplayOverviewHeader(true);
        $gcOptions->setHeight(100);

        // Set legend
        $gcLegend = new GCLegend();
        $gcLegend->setPosition("none");
        $gcOptions->setLegend($gcLegend);
        
        // Create vAxis
        $gcVAxis = new GCAxis();
        $gcVAxis->setTextPosition("none");
        $gcVAxis->setGridlines(new GCGridlines(0));
        
        // Add to options
        $gcOptions->setVAxis($gcVAxis);
        
        // Create hAxis
        $gcHAxis = new GCAxis();
        $gcHAxis->setTextPosition("top");

        // Add to options
        $gcOptions->setHAxis($gcHAxis);
        
        // Return options
        return $gcOptions;
    }
}
