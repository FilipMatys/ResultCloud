<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_SUITE);
Library::using(Library::CORLY_SERVICE_SUITE);

/**
 * CategoryService short summary.
 *
 * CategoryService description.
 *
 * @version 1.0
 * @author Filip
 */
class CategoryService
{
    private $CategoryDao;
    
    private $TestCaseService;
    
    /**
     * Category service constructor
     */
    public function __construct()   {
        $this->CategoryDao = new CategoryDao();
        $this->TestCaseService = new TestCaseService();
    }
    
    /**
     * Save categories of given submission
     * @param mixed $categories 
     * @param mixed $submissionId 
     */
    public function SaveCategories($categories, $submissionId) {
        foreach ($categories as $category)   {
            // Save category and test cases
            $categoryId = $this->CategoryDao->Save($category->GetDbObject($submissionId));
            $this->TestCaseService->SaveTestCases($category->GetTestCases(), $categoryId);
        }
    }
    
    /**
     * Load categories for given submission
     * @param mixed $submissionId 
     * @param mixed $depth
     * @return array of categories
     */
    public function LoadCategories($submissionId, $depth)   {
        // Load categories for given submission
        $dbCategories = $this->CategoryDao->GetFilteredList(QueryParameter::Where('Submission', $submissionId));
        
        // Initialize categories array
        $categories = array();
        
        // Map each category into TSE object and load their test cases
        foreach ($dbCategories as $dbCategory)
        {
            $category = new CategoryTSE();
            $category->MapDbObject($dbCategory);
            
            // If not reached depth, load test cases
            if ($depth > 0) {
                // Load test cases
                foreach ($this->TestCaseService->LoadTestCases($dbCategory->Id, $depth - 1) as $testCase)
                {
                    // Add test case to category
                    $category->AddTestCase($testCase);
                }
            }
            
            // Add category to array
            $categories[] = $category;
        }
        
        // Return list of categories
        return $categories;
    }
}
