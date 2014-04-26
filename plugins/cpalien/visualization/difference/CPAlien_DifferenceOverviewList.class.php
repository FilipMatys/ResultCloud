<?php

/**
 * CPAlien_DifferenceOverviewList short summary.
 *
 * CPAlien_DifferenceOverviewList description.
 *
 * @version 1.0
 * @author Filip
 */
class CPAlien_DifferenceOverviewList
{
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
        $categories = CPAlien_DifferenceOverviewList::GetGategoryNames($submissions);
        
        // Now, for each category, make difference overview list
        $differenceOverivewLists = array();
        foreach ($categories as $category)  {
            // Prepare difference overview list object
            $differenceOverviewList = new DifferenceOverviewList();
            
            // Set headers for list
            foreach ($submissions as $submission)   {
                $differenceOverviewList->AddHeader($submission->GetDateTime());  
            }
            
            
            // Before starting processing, we need to get all test cases
            // across each submission and assigned results. Then, we can
            // go through each submission and compare its values
            $testCases = CPAlien_DifferenceOverviewList::GetTestCasesHierarchy($submissions, $category);
            
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
                                    $differenceOverviewListItemResultValue->SetStyle(CPAlien_DifferenceOverviewList::GetStatusStyleByValue(CPALIEN_StatusValue::NO_VAL));
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
                                    $differenceOverviewListItemResultValue->SetStyle(CPAlien_DifferenceOverviewList::GetStatusStyleByValue(CPALIEN_StatusValue::NO_VAL));
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
                                    $differenceOverviewListItemResultValue->SetStyle(CPAlien_DifferenceOverviewList::GetStatusStyleByValue(CPALIEN_StatusValue::NO_VAL));
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
                            if ($prevValue->GetValue() != $subResult->GetValue())
                                $differenceOverviewListItemResultValue->SetStyle(CPAlien_DifferenceOverviewList::GetStatusStyleByValue($subResult->GetValue()));
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
     * Get style based on value
     * @param mixed $value 
     * @return mixed
     */
    private static function GetStatusStyleByValue($value)   {
        switch($value)  {
            case CPALIEN_StatusValue::ERROR:
                return CPALIEN_StatusStyle::ERROR;
            
            case CPALIEN_StatusValue::ERROR_PARSING:
                return CPALIEN_StatusStyle::ERROR_PARSING;
            
            case CPALIEN_StatusValue::EXCEPTION:
                return CPALIEN_StatusStyle::EXCEPTION;
            
            case CPALIEN_StatusValue::SAFE:
                return CPALIEN_StatusStyle::SAFE;
            
            case CPALIEN_StatusValue::TIMEOUT:
                return CPALIEN_StatusStyle::TIMEOUT;
            
            case CPALIEN_StatusValue::UNSAFE:
                return CPALIEN_StatusStyle::UNSAFE;
            
            case CPALIEN_StatusValue::NO_VAL:
                return CPALIEN_StatusStyle::NO_VAL;
            
            default:
                return "";
        }
    }
}
