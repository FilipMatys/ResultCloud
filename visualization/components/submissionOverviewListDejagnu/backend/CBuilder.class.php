<?php

/**
 * SystemTAP_SubmissionOverviewList short summary.
 *
 * SystemTAP_SubmissionOverviewList description.
 *
 * @version 1.0
 * @author Filip
 */
class CBuilder
{
    /**
     * Get submission overview list data for visualization
     * @param SubmissionTSE $project 
     * @return mixed
     */
    public static function Get($data)    {
        $page = $data->Metadata->Pagination;
        $pageSize = SettingsService::GetTemplateByIdentifier(
                'submission-overview-list-dejagnu', 
                $data->SubmissionTSE->GetProject()->GetId())->Data['page-size'];

        // Load data
        TestSuiteDataService::LoadCategories($data->SubmissionTSE, DataDepth::RESULT, new QueryPagination($page, $pageSize, 'asc'));

        // Initialize list
        $submissionOverviewList = new SubmissionOverviewList();

        // Iterate through categories        
        foreach ($data->SubmissionTSE->GetCategories() as $category) {
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
                    $submissionOverviewListItemCaseResult->SetStyle(self::GetStatusStyleByValue($result->GetValue()));
                    
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

        // Set page size
        $submissionOverviewList->SetPageSize($pageSize);
        
        // Set number of records
        $submissionOverviewList->SetItemsCount($data->SubmissionTSE->GetTotalCount());
        
        // Set available views
        $submissionOverviewList->AddView(SubmissionOverviewListType::GroupedView);
        
        // Return result
        return new ValidationResult($submissionOverviewList->ExportObject());
    }
    
    /**
     * Get style based on value
     * @param mixed $value 
     * @return mixed
     */
    private static function GetStatusStyleByValue($value)   {
        switch($value)  {
            case StatusValue::ERROR:
                return StatusStyle::ERROR;
            
            case StatusValue::FAIL:
                return StatusStyle::FAIL;
            
            case StatusValue::KFAIL:
                return StatusStyle::KFAIL;
            
            case StatusValue::XFAIL:
                return StatusStyle::XFAIL;
            
            case StatusValue::KPASS:
                return StatusStyle::KPASS;
            
            case StatusValue::PASS:
                return StatusStyle::PASS;
                
            case StatusValue::XPASS:
                return StatusStyle::XPASS;
                
            case StatusValue::UNSUPPORTED:
                return StatusStyle::UNSUPPORTED;
                
            case StatusValue::UNTESTED:
                return StatusStyle::UNTESTED;
            
            default:
                return "";
        }
    }
}
