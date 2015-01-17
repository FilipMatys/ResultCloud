<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::CORLY_DAO_IMPLEMENTATION_PLUGIN);
Library::using(Library::CORLY_SERVICE_SUITE);
Library::using(Library::CORLY_SERVICE_SESSION);
Library::using(Library::CORLY_SERVICE_UTILITIES);
Library::using(Library::CORLY_SERVICE_SECURITY);
Library::using(Library::CORLY_ENTITIES);
Library::using(Library::UTILITIES);

Library::using(Library::VISUALIZATION_COMPONENT_GOOGLECHART);

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
    
    private $PluginService;
    private $SubmissionService;
    
    /**
     * Project service constructor
     */
    public function __construct()   {
        $this->ProjectDao = new ProjectDao();
        $this->SubmissionService = new SubmissionService();
        $this->PluginService = new PluginService();
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
            $project->DateCreated = TimeService::DateTime();
            $project->Author = SessionService::GetSession('id');
        }
        
        // Save project
        $this->ProjectDao->Save($project);
        
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
        $dbProject = $this->ProjectDao->Load($project);
        
        // Load plugin
        $this->PluginService->LoadPlugin($dbProject->Plugin);
        
        // Initialize validation
        $validation = new ValidationResult($project);
        
        // Check if importer was included
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
        $dbProject = $this->ProjectDao->Load($project);
        
        // Load plugin
        $this->PluginService->LoadPlugin($dbProject->Plugin);
        
        // Initialize validation
        $validation = new ValidationResult($project);
        
        // Check if importer was included
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
        $dbProject = $this->ProjectDao->Load($project);
        
        // Map database object to TSE object
        $project = new ProjectTSE();
        $project->MapDbObject($dbProject);
        
        // Load plugin
        $this->PluginService->LoadPlugin($dbProject->Plugin);
        
        // Initialize validation
        $validation = new ValidationResult($project);
        
        // Check if importer was included
        if (!class_exists('Visualization'))  {
            $validation->AddError("Visualization for given plugin was not found");
            return $validation;
        }
        
        // End session to allow other requests
        SessionService::CloseSession();
        
        // Load submissions and add them to project
        foreach ($this->SubmissionService->LoadSubmissions($dbProject->Id, Visualization::GetProjectDataDepth($type)) as $submission)
        {
            // Add submission to project
            $project->AddSubmission($submission);
        }
        
        // Process data by plugin
        return Visualization::VisualizeProject($project, $type);
    }

    /**
     * Get project liveness
     */
    public function GetLiveness($project)   {
        // Get dates to create liveness for
        $dates = TimeService::MonthIntervalArray(TimeService::Date(), -12);

        // Get submissions of given project
        $submissions = $this->SubmissionService->GetFilteredList(QueryParameter::Where('Project', $project->Id));

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
        $gcHAxis->setTitle("Cau");
        $gcHAxis->setTextPosition("top");

        // Add to options
        $gcOptions->setHAxis($gcHAxis);
        
        // Return options
        return $gcOptions;
    }
}
