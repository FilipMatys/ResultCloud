<?php
// projectOverviewChart/backend/CBuilder.class.php

class CBuilder {
	// Get data for frontend
	public static function Get($data)	{
		// Load data for project
        TestSuiteDataService::LoadSubmissions($data->ProjectTSE, DataDepth::SUBMISSION,
            new QueryPagination(1, SettingsService::GetTemplateByIdentifier(
                'project-overview-chart', 
                $data->ProjectTSE->GetId())->Data['submissions-number'], 
                'desc'
            )
        );

        // Reverse order of submissions
        $data->ProjectTSE->ReverseSubmissions();

        // Initialize Google chart object
        $projectOverviewChart = new OverviewChart();
        $googleChart = new GoogleChart();
        
        $googleChart->setType(GCType::COLUMN_CHART);
        
        // Assign options to chart
        $googleChart->setOptions(self::GetGCOptions());
        
        // Get data
        $googleChart->setData(self::GetGCData($data->ProjectTSE));
        
        // Set overview chart to google chart
        $projectOverviewChart->SetChart($googleChart);
        // Add possible values
        $projectOverviewChart->AddType(GCType::AREA_CHART);
        $projectOverviewChart->AddType(GCType::COLUMN_CHART);
        $projectOverviewChart->AddType(GCType::LINE_CHART);
        
        // return google chart object
        return new ValidationResult($projectOverviewChart->ExportObject());
	}
	
	/**
     * Get google chart data
     * @param ProjectTSE $project 
     * @return mixed
     */
    private static function GetGCData(ProjectTSE $project)  {
        // Initialize data
        $gcData = new GCData();
        
        // Initialize array to hold submissions
        $submissions = array();
        
        // In this state, we need results for each submission,
        // these results are then proccessed without any other 
        // needed information
        foreach ($project->GetSubmissions() as $submission)
        {
            // Save results to array, this array has to be 
            // dictionary so we are sure where each result
            // set belongs
            $submissions[$submission->GetDateTime()] = SummaryController::Load('ResultsSummary', $submission);    
        }
        
        // Now merge all results into one, to get all possible columns
        $columns = array();
        foreach ($submissions as $submissionResultSet)
        {
            // Merge arrays
            $lSet = new LINQ($submissionResultSet);
            $columns = array_merge($columns, $lSet->Select('Name')->ToList());
            // And make it unique, because we only need to know the columns
            $columns = array_unique($columns);
        }
        
        // For now we have columns, we can start creating chart,
        // the first one is submission itself
        $colSubmission = new GCCol();
        $colSubmission->setId("submission");
        $colSubmission->setLabel("Submission");
        $colSubmission->setType("string");
        // Add to data set
        $gcData->AddColumn($colSubmission);
        
        // The next ones are values
        foreach ($columns as $column)
        {
            // Create new column
            $gcCol = new GCCol();
            $gcCol->setId("status-".$column);
            $gcCol->setLabel($column);
            $gcCol->setType("number");
            // Add to data set
            $gcData->AddColumn($gcCol);
        }
        
        // For each submission there is, create new row and assign cells
        foreach ($submissions as $dateCreated => $results)
        {
            // Create new row
            $gcRow = new GCRow();
            
            // Before getting any values, first cell is submission
            $gcCell = new GCCell();
            $gcCell->setValue($dateCreated);
            // Add cell to row
            $gcRow->AddCell($gcCell);
            
            // Load results into LINQ object
            $lResults = new LINQ($results);
            
            // Go through each column and get value for it
            foreach ($columns as $column)
            {
                // Create new cell
                $gcCell = new GCCell();
                
                // Get value for given name
                $lValue = $lResults->Where('Name', LINQ::IS_EQUAL, $column);
                if ($lValue->IsEmpty())
                    $gcCell->setValue(0);
                else
                    $gcCell->setValue($lValue->Select('Value')->Single());
                
                // Add cell to row
                $gcRow->AddCell($gcCell);
            }
            
            // Add row to data set
            $gcData->AddRow($gcRow);
        }
        
        // Return data
        return $gcData;
    }
    
    /**
     * Get google chart options
     * @return mixed
     */
    private static function GetGCOptions()  {
        // Create options and set all in it
        $gcOptions = new GCOptions();
        $gcOptions->setFill(20);
        $gcOptions->setTitle("Running results");
        $gcOptions->setDisplayOverviewHeader(true);
        
        // Create vAxis
        $gcVAxis = new GCAxis();
        $gcVAxis->setGridlines(new GCGridlines(10));
        $gcVAxis->setTitle("Result count");
        
        // Add to options
        $gcOptions->setVAxis($gcVAxis);
        
        // Create hAxis
        $gcHAxis = new GCAxis();
        $gcHAxis->setTitle("Submission");
        
        // Add to options
        $gcOptions->setHAxis($gcHAxis);
        
        // Return options
        return $gcOptions;
    }
}

?>