<?php

/**
 * GLIBC_DifferenceOverview short summary.
 *
 * GLIBC_DifferenceOverview description.
 *
 * @version 1.0
 * @author Filip
 */
class GLIBC_DifferenceOverviewChart
{
    /**
     * Get Project Overview Chart for visualization
     * @param ProjectTSE $project 
     * @return mixed
     */
    public static function GetDifferenceOverviewChart($submissions)    {
        // Initialize Google chart object
        $differenceOverviewChart = new DifferenceOverviewChart();
        $googleChart = new GoogleChart();
        
        $googleChart->setType(GCType::LINE_CHART);
        
        // Assign options to chart
        $googleChart->setOptions(GLIBC_DifferenceOverviewChart::GetGCOptions());
        
        // Get data
        $googleChart->setData(GLIBC_DifferenceOverviewChart::GetGCData($submissions));
        
        // Set overview chart to google chart
        $differenceOverviewChart->SetChart($googleChart);
        // Add possible values
        $differenceOverviewChart->AddType(GCType::LINE_CHART);
        $differenceOverviewChart->AddType(GCType::AREA_CHART);
        $differenceOverviewChart->AddType(GCType::COLUMN_CHART);
        
        // return google chart object
        return $differenceOverviewChart->ExportObject();
    }
    
    /**
     * Get google chart data
     * @param ProjectTSE $project 
     * @return mixed
     */
    private static function GetGCData($tseSubmissions)  {
        // Initialize data
        $gcData = new GCData();
        
        // Initialize array to hold submissions
        $submissions = array();
        
        // In this state, we need results for each submission,
        // these results are then proccessed without any other 
        // needed information
        foreach ($tseSubmissions as $submission)
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
            $gcCol->setId("error-".$column);
            $gcCol->setLabel("Error ".$column);
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
        $gcOptions->setTitle("Error codes");
        
        // Create vAxis
        $gcVAxis = new GCAxis();
        $gcVAxis->setGridlines(new GCGridlines(10));
        $gcVAxis->setTitle("Code count");
        
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
