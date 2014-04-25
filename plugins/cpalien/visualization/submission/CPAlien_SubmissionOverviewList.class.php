<?php

/**
 * CPAlien_SubmissionOverviewList short summary.
 *
 * CPAlien_SubmissionOverviewList description.
 *
 * @version 1.0
 * @author Filip
 */
class CPAlien_SubmissionOverviewList
{
    // Constants
    const PAGE_SIZE = 100;
    
    /**
     * Get submission overview list data for visualization
     * @param SubmissionTSE $project 
     * @return mixed
     */
    public static function GetSubmissionOverviewList(SubmissionTSE $submission, $page)    {
        // Initialize list
        $submissionOverviewList = new SubmissionOverviewList();
        
        // Initialize items count
        $itemsCount = 0;
        
        foreach ($submission->GetCategories() as $category)
        {
            $itemsCount += $category->GetNumberOfTestCases();
            $category->SpliceTestCases(($page - 1) * CPAlien_SubmissionOverviewList::PAGE_SIZE, CPAlien_SubmissionOverviewList::PAGE_SIZE);
            
            // Create new list item
            $submissionOverviewListItem = new SubmissionOverviewListItem($category->GetName());
            
            // Iterate through test cases
            foreach ($category->GetTestCases() as $testCase) {
                // Set test case
                $submissionOverviewListItemCase = new SubmissionOverviewListItemCase($testCase->GetName());
                
                // Iterate through each result
                foreach ($testCase->GetResults() as $result) {
                    // Create new result
                    $submissionOverviewListItemCaseResult = new SubmissionOverviewListItemCaseResult($result);  
                    
                    // Set style
                    $submissionOverviewListItemCaseResult->SetStyle(CPAlien_SubmissionOverviewList::GetStatusStyleByValue($result->GetValue()));
                    
                    // Add result to submission case
                    $submissionOverviewListItemCase->AddResult($submissionOverviewListItemCaseResult);
                }
                
                // Add test case to list item
                $submissionOverviewListItem->AddTestCase($submissionOverviewListItemCase);
            }
            
            // Add item to list
            $submissionOverviewList->AddItem($submissionOverviewListItem);
        }
        
        // Set page number
        $submissionOverviewList->SetPage($page);
        
        // Set number of records
        $submissionOverviewList->SetItemsCount($itemsCount);
        
        // Set available views
        $submissionOverviewList->AddView(SubmissionOverviewListType::GroupedView);
        $submissionOverviewList->AddView(SubmissionOverviewListType::ListView);
        
        // Return result
        return $submissionOverviewList->ExportObject();
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
            
            default:
                return "";
        }
    }
}
