<?php

/**
 * GLIBC_DifferenceOverviewDiffSummary short summary.
 *
 * GLIBC_DifferenceOverviewDiffSummary description.
 *
 * @version 1.0
 * @author Filip
 */
class GLIBC_DifferenceOverviewDiffSummary
{
    /**
     * Get Difference Overview Difference Summary
     * @param mixed $submissions 
     * @return mixed
     */
    public static function GetDifferenceOverviewDiffSummary($submissions)   {
        // Init diff object
        $diffSummaryOverview = new GLIBC_DiffSummary();
        // Init array of categories
        $categoryNames = array();
        
        // Iterate through submissions
        foreach ($submissions as $submission)   {
            
            // Get diff summary header
            $diffSummaryOverview->AddHeader($submission->GetDateTime());
            // Init errors count
            $errorsCount = 0;
            
            // Go through each category
            foreach ($submission->GetCategories() as $category) {
                // Add category name to array
                $categoryNames[] = $category->GetName();
                
                // Get number of test cases
                $errorsCount += $category->GetNumberOfTestCases();
            }
            
            // Set error count
            $diffSummaryOverview->AddCount(new GLIBC_DiffSummaryValue($errorsCount));
        }
        
        // After getting all category names, go through each submission again 
        // and create summary per category
        
        // Make category unique
        $categoryNames = array_unique($categoryNames);
        // Iterate through each category name
        foreach ($categoryNames as $categoryName)   {
            // Init category object
            $differenceSummaryCategory = new GLIBC_DiffSummaryCategory($categoryName);
            
            // Go through each submission
            foreach ($submissions as $submission) {
                // Get category by name  
                $category = $submission->GetCategoryByName($categoryName);
                // Check if submission has given category
                if (!is_null($category))
                    $differenceSummaryCategory->AddCount(new GLIBC_DiffSummaryValue($category->GetNumberOfTestCases()));
                else
                    $differenceSummaryCategory->AddCount(new GLIBC_DiffSummaryValue());
            }
            
            // Add category to overview
            $diffSummaryOverview->AddCategory($differenceSummaryCategory);
        }
        
        
        // Return result
        return $diffSummaryOverview->ExportObject();
    } 
}
