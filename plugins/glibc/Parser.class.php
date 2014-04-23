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
    // Value indexes
    const WHOLE_STRING = 0;
    const CATEGORY = 1;
    const TEST_CASE = 2;
    const RESULT_KEY = 3;
    const RESULT_VAL = 4;

    /**
     * Parse imported data
     */
    public static function ParseImport($data)   {
        // Read file data
        $fileContent = file_get_contents($data);
        
        // Create submission
        $Submission = new SubmissionTSE(date("c"));
        
        // Get all needed rows
        preg_match_all("/(make\[\d\]): \*\*\* \[(.*)\] (.*) (\d+)/", $fileContent, $matches);
        
        // Array of categories
        $lCategories = new LINQ(array()); 
        
        // Iterate throught each found record        
        for ($index = 0; $index < count($matches[Parser::WHOLE_STRING]); $index++) {
            // Init category
            $Category = new CategoryTSE($matches[Parser::CATEGORY][$index]);
         
            // Init  test case 
            $TestCase = new TestCaseTSE($matches[Parser::TEST_CASE][$index]);
          
            // Create result
            $Result = new ResultTSE($matches[Parser::RESULT_KEY][$index], $matches[Parser::RESULT_VAL][$index]);
            
            // Add result to test case
            $TestCase->AddResult($Result);
            // Add test case to category
            $Category->AddTestCase($TestCase);
            
            $lCategories->Add($Category);
        }
        
        // Merge categories and create final result
        // Iterate through each record
        foreach ($lCategories->GroupBy('Name')->ToList() as $items)    {
        
            // Create category
            $Category = new CategoryTSE($items[0]->Name);
            
            // Add each test case to category
            foreach ($items as $category)  {
                $lTestCases = new LINQ($category->GetTestCases());
                $Category->AddTestCase($lTestCases->Single());
            }
            
            // Add category to submission
            $Submission->AddCategory($Category);
        }
        
        // Set validation
        $validation = new ValidationResult($Submission);
        
        // Return validation with data
        return $validation;
    }
}
