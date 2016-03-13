<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

Library::using(Library::UTILITIES);

class ResultsSummary
{
    public function Summarize(SubmissionTSE $submissionTSE) {
        // Init validation
        $validation = new ValidationResult(array());
        // Load data
        TestSuiteDataService::LoadCategories($submissionTSE, DataDepth::RESULT);

        // Initialize results list
        $subResults = array();
        
        // First, we need to get all results of given submission
        foreach ($submissionTSE->GetCategories() as $category) {
            // Iterate through each test case
            foreach ($category->GetTestCases() as $testCase)    {
                // Iterate through each result and get "status" value
                foreach ($testCase->GetResults() as $result) {
                    $subResults[] = $result->GetValue();
                }
            }
        }

        // Then, get unique array of column values
        $keys = array_unique($subResults);

        // Create entities
        $lSubResults = new LINQ($subResults);
        foreach ($keys as $key) {
            // Create new entity
            $entity = new ResultsSummaryEntity();
            
            $entity->Name = $key;
            $entity->Value = $lSubResults->Where(null, LINQ::IS_EQUAL, $key)->Count();
            $entity->Submission = $submissionTSE->GetId();
            
            $validation->Data[] = $entity;
        }

        // Return validation
        return $validation;
    }
}

class ResultsSummaryEntity {
    public $Name;
    public $Value;
    public $Submission;
}

?>