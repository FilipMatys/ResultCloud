<?php

/**
 * SystemTAP_SubmissionOverviewList short summary.
 *
 * SystemTAP_SubmissionOverviewList description.
 *
 * @version 1.0
 * @author Filip
 */
class SystemTAP_SubmissionOverviewList
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
        
        foreach ($submission->GetCategories() as $category) {
            $itemsCount += $category->GetNumberOfTestCases();
            $category->SpliceTestCases(($page - 1) * SystemTAP_SubmissionOverviewList::PAGE_SIZE, SystemTAP_SubmissionOverviewList::PAGE_SIZE);
            
            // Create new list item
            $submissionOverviewListItem = new SubmissionOverviewListItem($category->GetName());
            $submissionOverviewListItem->SetNumberOfTestCases($category->GetNumberOfTestCases());
            
            // Iterate through test cases
            foreach ($category->GetTestCases() as $testCase) {
                // Set test case
                $submissionOverviewListItemCase = new SubmissionOverviewListItemCase($testCase->GetName());
                
                // Iterate through each result
                foreach ($testCase->GetResults() as $result) {
                    // Create new result
                    $submissionOverviewListItemCaseResult = new SubmissionOverviewListItemCaseResult($result);  
                    
                    // Set style
                    $submissionOverviewListItemCaseResult->SetStyle(SystemTAP_SubmissionOverviewList::GetStatusStyleByValue($result->GetValue()));
                    
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
            case SystemTAP_StatusValue::ERROR:
                return SystemTAP_StatusStyle::ERROR;
            
            case SystemTAP_StatusValue::FAIL:
                return SystemTAP_StatusStyle::FAIL;
            
            case SystemTAP_StatusValue::KFAIL:
                return SystemTAP_StatusStyle::KFAIL;
            
            case SystemTAP_StatusValue::XFAIL:
                return SystemTAP_StatusStyle::XFAIL;
            
            case SystemTAP_StatusValue::KPASS:
                return SystemTAP_StatusStyle::KPASS;
            
            case SystemTAP_StatusValue::PASS:
                return SystemTAP_StatusStyle::PASS;
                
            case SystemTAP_StatusValue::XPASS:
                return SystemTAP_StatusStyle::XPASS;
                
            case SystemTAP_StatusValue::UNSUPPORTED:
                return SystemTAP_StatusStyle::UNSUPPORTED;
                
            case SystemTAP_StatusValue::UNTESTED:
                return SystemTAP_StatusStyle::UNTESTED;
            
            default:
                return "";
        }
    }
}
