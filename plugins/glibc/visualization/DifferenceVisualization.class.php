<?php

/**
 * DifferenceVisualization short summary.
 *
 * DifferenceVisualization description.
 *
 * @version 1.0
 * @author Filip
 */
class DifferenceVisualization
{
    // Style for 
    const NO_ERROR = "background: #2ecc71; color: #ffffff";
    const ERROR = "background: #e74c3c; color: #ffffff";
    
    /**
     * Visualize difference submission type
     * @param mixed $submissions 
     * @param mixed $type 
     * @param mixed $meta 
     * @return mixed
     */
    public static function Visualize($submissions, $type, $meta) {
        // Choose the right data based on component type
        switch($type)   {
            // Return difference lists
            case DifferenceOverviewType::VIEWLIST:
                return DifferenceVisualization::GetDifferenceOverviewLists($submissions);
            
            case DifferenceOverviewType::GOOGLE_CHART:
                return DifferenceVisualization::GetDifferenceOverviewChart($submissions);
                
            default:
                return null;
        }
    }
    
    /**
     * Get data depth based on component type
     * @param mixed $type 
     * @return mixed
     */
    public static function GetDataDepth($type)   {
        // Set data depth based on component type
        switch($type)   {
            case DifferenceOverviewType::VIEWLIST:
                return DataDepth::RESULT;
                
            case DifferenceOverviewType::GOOGLE_CHART:
                return DataDepth::RESULT;
                
            default:
                return DataDepth::SUBMISSION;
        }
    }
    
    /**
     * Get components for plugin
     * @return mixed
     */
    public static function GetViewComponents()   {
        return array(
                DifferenceOverviewComponent::GOOGLE_CHART,
                DifferenceOverviewComponent::VIEWLIST
            );
    }
    
    /**
     * Get unique array of category names of given
     * submissions
     * @param mixed $submissions 
     * @return mixed
     */
    private static function GetGategoryNames($submissions)  {
        // Initialize array of categories
        $categories = array();
        
        // Iterate through each submission
        foreach ($submissions as $submission)   {
            // Get all categories for given submission
            foreach ($submission->GetCategories() as $category) {
                $categories[] = $category->GetName();         
            }
        }
        
        // Make the array unique, so it contains each category only once
        return array_unique($categories);;
    }
    
    /**
     * Get test case hierarchy of given category across all
     * given submissions
     * @param mixed $submissions 
     * @param mixed $category 
     * @return mixed
     */
    private static function GetTestCasesHierarchy($submissions, $category) {
        // Initialize result
        $testCases = array();
        
        // Iterate through each submission
        foreach ($submissions as $submission)   {
            // Get active category
            $subCategory = $submission->GetCategoryByName($category);
            // Check if category was found, if not, continue
            if (is_null($subCategory))
                continue;
            
            // Get all test cases, and for each test case, assign its
            // name as a key, and results keys as values. These will
            // be used later for comparation
            foreach ($subCategory->GetTestCases() as $testCase) {
                // Initialize new test case record if not yet exists
                if (!isset($testCases[$testCase->GetName()]))
                    $testCases[$testCase->GetName()] = array();
                
                // Iterate through each result and assign it to test case
                foreach ($testCase->GetResults() as $result)    {
                    $testCases[$testCase->GetName()][] = $result->GetKey();                 
                }
            }
        }
        
        // Return result
        return $testCases;
    } 
    
    /**
     * Get difference overview lists
     * @param mixed $submissions 
     * @return mixed
     */
    public static function GetDifferenceOverviewLists($submissions) {
        // For each category, one list is created, so first get all
        // categories across all submissions
        $categories = DifferenceVisualization::GetGategoryNames($submissions);
        
        // Now, for each category, make difference overview list
        $differenceOverivewLists = array();
        foreach ($categories as $category)  {
            // Prepare difference overview list object
            $differenceOverviewList = new DifferenceOverviewList();
            $differenceOverviewList->SetName($category);
            
            // Set headers for list
            foreach ($submissions as $submission)   {
                $differenceOverviewList->AddHeader($submission->GetDateTime());  
            }
            
            
            // Before starting processing, we need to get all test cases
            // across each submission and assigned results. Then, we can
            // go through each submission and compare its values
            $testCases = DifferenceVisualization::GetTestCasesHierarchy($submissions, $category);
            
            // After iterating through each submissions category and getting all test
            // cases and its results, these results must be made unique. After that,
            // processing may start
            foreach ($testCases as $testCase => $resultKeys)   {
                // Make array of results unique
                $resultKeys = array_unique($resultKeys);
                
                // Create new difference overview list item
                $differenceOverviewListItem = new DifferenceOverviewListItem($testCase);
                
                // Iterate through each key
                foreach ($resultKeys as $key) {
                    // Create new difference overview list item result set
                    $differenceOverviewListItemResultSet = new DifferenceOverviewListItemResultSet($key);
                    // Iterate through each submission 
                    foreach ($submissions as $submission) {
                        // Get category of given submission
                        $subCategory = $submission->GetCategoryByName($category);
                        
                        // If category of given name was not found,
                        // create empty record and continue with other
                        // submission
                        if (is_null($subCategory))  {
                            $differenceOverviewListItemResultValue = new DifferenceOverviewListItemResultSetValue();
                            
                            // Get previous result
                            $prevValue = $differenceOverviewListItemResultSet->GetLastInsertedValue();
                            if (!is_null($prevValue))   {
                                // Set no error
                                if ($prevValue->GetValue() != "")
                                     $differenceOverviewListItemResultValue->SetStyle(DifferenceVisualization::NO_ERROR);
                            }
                            
                            $differenceOverviewListItemResultSet->AddValue($differenceOverviewListItemResultValue);
                            continue;
                        }
                        
                        // Get test case of given category
                        $subTestCase = $subCategory->GetTestCaseByName($testCase);
                        
                        // If test case of given name was not found,
                        // create empty record and continue with other
                        // submission
                        if (is_null($subTestCase))  {
                            $differenceOverviewListItemResultValue = new DifferenceOverviewListItemResultSetValue();
                            
                            // Get previous result
                            $prevValue = $differenceOverviewListItemResultSet->GetLastInsertedValue();
                            if (!is_null($prevValue))   {
                                // Set no error
                                if ($prevValue->GetValue() != "")
                                    $differenceOverviewListItemResultValue->SetStyle(DifferenceVisualization::NO_ERROR);
                            }
                            
                            $differenceOverviewListItemResultSet->AddValue($differenceOverviewListItemResultValue);
                            continue;
                        }
                        
                        // Get result by active key
                        $subResult = $subTestCase->GetResultByKey($key);
                        
                        // If not result of given key was found,
                        // create empty record and continue with
                        // another submission
                        if (is_null($subResult))  {
                            $differenceOverviewListItemResultValue = new DifferenceOverviewListItemResultSetValue();
                            
                            // Get previous result
                            $prevValue = $differenceOverviewListItemResultSet->GetLastInsertedValue();
                            if (!is_null($prevValue))   {
                                // Set no error
                                if ($prevValue->GetValue() != "")
                                    $differenceOverviewListItemResultValue->SetStyle(DifferenceVisualization::NO_ERROR);
                            }
                            
                            $differenceOverviewListItemResultSet->AddValue($differenceOverviewListItemResultValue);
                            continue;
                        }
                        // Assign value to result set
                        $differenceOverviewListItemResultValue = new DifferenceOverviewListItemResultSetValue($subResult->GetValue());
                        
                        // Get previous result
                        $prevValue = $differenceOverviewListItemResultSet->GetLastInsertedValue();
                        if (!is_null($prevValue))   {
                            // Set no error
                            if ($prevValue->GetValue() == "")
                                $differenceOverviewListItemResultValue->SetStyle(DifferenceVisualization::ERROR);
                        }
                        
                        $differenceOverviewListItemResultSet->AddValue($differenceOverviewListItemResultValue);
                    }
                    // Add result set to list item
                    $differenceOverviewListItem->AddResultSet($differenceOverviewListItemResultSet);
                }
                // Add item to list
                $differenceOverviewList->AddItem($differenceOverviewListItem);
            }
            // Add listview to list
            $differenceOverivewLists[] = $differenceOverviewList->ExportObject();
        }
        
        // Return result
        return $differenceOverivewLists;
    }
    
    /**
     * Get Project Overview Chart for visualization
     * @param ProjectTSE $project 
     * @return mixed
     */
    private static function GetDifferenceOverviewChart($submissions)    {
        // Initialize Google chart object
        $differenceOverviewChart = new DifferenceOverviewChart();
        $googleChart = new GoogleChart();
        
        $googleChart->setType(GCType::COLUMN_CHART);
        
        // Assign options to chart
        $googleChart->setOptions(DifferenceVisualization::GetGCOptions());
        
        // Get data
        $googleChart->setData(DifferenceVisualization::GetGCData($submissions));
        
        // Set overview chart to google chart
        $differenceOverviewChart->SetChart($googleChart);
        // Add possible values
        $differenceOverviewChart->AddType(GCType::AREA_CHART);
        $differenceOverviewChart->AddType(GCType::COLUMN_CHART);
        $differenceOverviewChart->AddType(GCType::LINE_CHART);
        
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
