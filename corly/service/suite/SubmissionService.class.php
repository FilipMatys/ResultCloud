<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_SUITE);

/**
 * SubmissionService short summary.
 *
 * SubmissionService description.
 *
 * @version 1.0
 * @author Filip
 */
class SubmissionService
{
    private $SubmissionDao;
    private $CategoryDao;
    private $TestCaseDao;
    private $ResultDao;

    /**
     * Constructor to initialize daos
     */
    public function __construct()   {
        $SubmissionDao = new SubmissionDao();
        $CategoryDao = new CategoryDao();
        $ResultDao = new ResultDao();
        $TestCaseDao = new TestCaseDao();
    }
    

    /**
     * Save data into database
     */
    public function Save($submission)    {
        // Init validation
        $validation = $this->ValidateSubmission($submission);
        
        // Prepare categories
        $categories = $submission->Categories;
        unset($submission->Categories);
        
        // Save submission
        $submissionId = $this->SubmissionDao->Save($submission);
        
        // Save categories with results
        $this->SaveCategories($categories, $submissionId);
        
        // Return validation
        return $validation;
    }
    
    /**
     * Save categories into database
     */
    private function SaveCategories($categories, $submissionId) {
        foreach ($categories as $category)   {
            // Prepare test cases
            $testCases = $category->TestCases;
            unset($category->TestCases);
            
            // Save category and test cases
            $categoryId = $this->CategoryDao->Save($category);
            $this->SaveTestCases($testCases, $categoryId);
        }
    }
    
    /**
     * Save test cases into database
     */
     private function SaveTestCases($testCases, $categoryId)    {
        foreach($testCases as $testCase)    {
            // Prepare results
            $results = $testCase->Results;
            unset($testCase->Results);
            
            // Save test case and results
            $testCaseId = $this->TestCaseDao->Save($testCase);
            $this->SaveResults($results, $testCaseId);
        }
     }
     
    
    /**
     * Save results into database
     */
    private function SaveResults($results, $testCaseId) {
        foreach ($results as $result)  {
            // Prepare result
            $result->Category = $categoryId;
            // Save
            $this->ResultDao->Save($result);
        }
    }
    
    /**
     * Validate submission data
     */
    private function ValidateSubmission($data)   {
        // Initialize validation 
        $validation = new ValidationResult($data);
        
        // Check if there are any data
        $validation->CheckDataNotNull();
        
        // Check validation result
        if (!$validation->IsValid)  {
            return $validation;
        }
        
        return $validation;
    }
    
}
