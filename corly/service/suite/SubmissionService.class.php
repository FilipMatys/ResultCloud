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
    private $ResultDao;

    /**
     * Constructor to initialize daos
     */
    public function __construct()   {
        $SubmissionDao = new SubmissionDao();
        $CategoryDao = new CategoryDao();
        $ResultDao = new ResultDao();
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
            // Prepare results
            $results = $category->Results;
            unset($category->Results);
            
            // Save category and results
            $categoryId = $this->CategoryDao->Save($category);
            $this->SaveResults($results, $categoryId);
        }
    }
    
    /**
     * Save results into database
     */
    private function SaveResults($results, $categoryId) {
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
