<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_ENTITIES);

/**
 * Parser short summary.
 *
 * Parser description.
 *
 * @version 1.0
 * @author Filip
 */
class Parser
{
    /**
     * Parse uploaded data for import
     */
    public static function ParseImport($data)    {
        // Load uploaded file as string
        $fileRows = file($data);
        
        $Category = new CategoryTSE("Default");
        // Iterate through array (rows)
        foreach ($fileRows as $row) {
            
            // Check for date and time
            if (!isset($Submission) && preg_match("/Test Run By (.*) on (.*)/", $row, $headerMatch))    {
                $Submission = new SubmissionTSE($headerMatch[2]);
            }
        
            // Check for test case header
            if (preg_match("/Running (\.\.\/.*) \.{3}/", $row, $testCaseMatches))   {
                
                // If test case was set, add it to category,
                // because we are creating new test case
                if (isset($TestCase))   {
                    $Category->AddTestCase($TestCase);
                }
                
                // Create new test case
                $TestCase = new TestCaseTSE($testCaseMatches[1]);
            }
            // Check for result
            else if (preg_match("/([A-Z]*): (.*)/", $row, $resultMatches))  {
                // Create result object
                $Result = new ResultTSE($resultMatches[2], $resultMatches[1]);
                
                // Add result to test case, if there is any
                if (isset($TestCase))   {
                    $TestCase->AddResult($Result);
                }
            }
        }
        
        // Add category to submission
        $Submission->AddCategory($Category);
        
        $validation = new ValidationResult($Submission);
        return $validation;
    }   
}
