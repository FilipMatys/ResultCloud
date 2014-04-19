<?php

/**
 * ProjectVisualisation short summary.
 *
 * ProjectVisualisation description.
 *
 * @version 1.0
 * @author Filip
 */
class ProjectVisualization
{
    /**
     * Visualize project detail
     * @param ProjectTSE $project 
     * @return mixed
     */
    public static function Visualize(ProjectTSE $project)   {
        // Inititalize project visualization
        $projectVisualization = new ProjectOverviewVisualization();
        
        // Set project overview list
        $projectVisualization->SetProjectOverviewList(ProjectVisualization::GetProjectOverviewList($project));
        
        // Set project overview chart
        $projectVisualization->SetProjectOverviewChart(ProjectVisualization::GetProjectOverviewChart($project));
        
        // Return result
        return $projectVisualization->ExportObject();
    }
    
    /**
     * Get project overview list data for visualization
     * @param ProjectTSE $project 
     * @return mixed
     */
    private static function GetProjectOverviewList(ProjectTSE $project)    {
        // Initialize list
        $projectOverviewList = new ProjectOverviewList();
        
        foreach ($project->GetSubmissions() as $submission)
        {
            // Create new list item
            $projectOverviewListItem = new ProjectOverviewListItem($submission);
            // Add item to list
            $projectOverviewList->AddItem($projectOverviewListItem);
        }
        
        // Return result
        return $projectOverviewList;
    }
    
    /**
     * Get Project Overview Chart for visualization
     * @param ProjectTSE $project 
     * @return mixed
     */
    private static function GetProjectOverviewChart(ProjectTSE $project)    {
        // Initialize Google chart object
        $projectOverviewChart = new ProjectOverviewChart();
        $googleChart = new GoogleChart();
        
        $googleChart->setType(GCType::COLUMN_CHART);
        
        // Assign options to chart
        $googleChart->setOptions(ProjectVisualization::GetGCOptions());
        
        // Get data
        $googleChart->setData(ProjectVisualization::GetGCData($project));
        
        // Set overview chart to google chart
        $projectOverviewChart->SetChart($googleChart);
        // Add possible values
        $projectOverviewChart->AddType(GCType::AREA_CHART);
        $projectOverviewChart->AddType(GCType::COLUMN_CHART);
        $projectOverviewChart->AddType(GCType::LINE_CHART);
        
        // return google chart object
        return $projectOverviewChart;
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
            // Initalize array to hold results
            $subResults = array();
            
            // Go through each category
            foreach ($submission->GetCategories() as $category)
            {
                // And each test case
                foreach ($category->GetTestCases() as $testCase)
                {
                    // Go through each result
                    foreach ($testCase->GetResults() as $result)
                    {
                        // Save value to array
                        $subResults[] = $result->GetValue();
                    }
                }
            }
            // Save results to array, this array has to be 
            // dictionary so we are sure where each result
            // set belongs
            $submissions[$submission->GetDateTime()] = $subResults;
        }
        
        // Now merge all results into one, to get all possible columns
        $columns = array();
        foreach ($submissions as $submissionResultSet)
        {
            // Merge arrays
            $columns = array_merge($columns, $submissionResultSet);
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
                
                // Set value
                $gcCell->setValue($lResults->Where(null, LINQ::IS_EQUAL, $column)->Count());
                
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
