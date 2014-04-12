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
     * Initialize class daos
     */
    public function __construct()   {
        $this->SubmissionDao = new SubmissionDao();
        $this->CategoryDao = new CategoryDao();
        $this->ResultDao = new ResultDao();
        $this->TestCaseDao = new TestCaseDao();
    }
    

    /**
     * Save summary as a whole, which means 
     * save all appended objects as well
     * @param mixed $submission 
     * @param mixed $projectId 
     * @return validation
     */
    public function Save($submission, $projectId)    {
        // Init validation
        $validation = $this->ValidateSubmission($submission);

        // Save submission
        $submissionId = $this->SubmissionDao->Save($submission->GetDbObject($projectId));
        
        // Save categories with test cases
        $this->SaveCategories($submission->GetCategories(), $submissionId);
        
        // Return validation
        return $validation;
    }
    
    /**
     * Save categories of given submission
     * @param mixed $categories 
     * @param mixed $submissionId 
     */
    private function SaveCategories($categories, $submissionId) {
        foreach ($categories as $category)   {
            // Save category and test cases
            $categoryId = $this->CategoryDao->Save($category->GetDbObject($submissionId));
            $this->SaveTestCases($category->GetTestCases(), $categoryId);
        }
    }
    
     /**
      * Save test cases of given category
      * @param mixed $testCases 
      * @param mixed $categoryId 
      */
     private function SaveTestCases($testCases, $categoryId)    {
        foreach($testCases as $testCase)    {
            // Prepare results
            $results = $testCase->GetResults();
            
            // Save test case and results
            $testCaseId = $this->TestCaseDao->Save($testCase->GetDbObject($categoryId));
            $this->SaveResults($results, $testCaseId);
        }
     }
     
    
    /**
     * Save results of given test case
     * @param mixed $results 
     * @param mixed $testCaseId 
     */
    private function SaveResults($results, $testCaseId) {
        foreach ($results as $result)  {
            // Save result
            $this->ResultDao->Save($result->GetDbObject($testCaseId));
        }
    }
    
    /**
     * Validate submission data
     */
    private function ValidateSubmission($data)   {
        // Initialize validation 
        $validation = new ValidationResult($data);
        
        // Check if there are any data
        $validation->CheckDataNotNull("Neplatná data");
        
        // Check validation result
        if (!$validation->IsValid)  {
            return $validation;
        }
        
        return $validation;
    }
    
}