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
                    //$submissionOverviewListItemCaseResult->SetStyle(SystemTAP_SubmissionOverviewList::GetStatusStyleByValue($result->GetValue()));
                    
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
}
