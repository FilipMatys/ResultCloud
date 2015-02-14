<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryDao.class.php']);

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
    /**
     * Save categories of given submission
     * @param mixed $categories 
     * @param mixed $submissionId 
     */
    public function SaveCategories($categories, $submissionId) {
        foreach ($categories as $category)   {
            // Save category and test cases
            $categoryId = FactoryDao::CategoryDao()->Save($category->GetDbObject($submissionId));
            FactoryService::TestCaseService()->SaveTestCases($category->GetTestCases(), $categoryId);
        }
    }
    
    /**
     * Load categories for given submission
     * @param mixed $submissionId 
     * @param mixed $depth
     * @return array of categories
     */
    public function LoadCategories($submissionTSE, $depth)   {
        // Load categories for given submission
        $dbCategories = FactoryDao::CategoryDao()->GetFilteredList(QueryParameter::Where('Submission', $submissionTSE->GetId()))->ToList();
        
        // Map each category into TSE object and load their test cases
        foreach ($dbCategories as $dbCategory)
        {
            $category = new CategoryTSE();
            $category->MapDbObject($dbCategory);
            
            // If not reached depth, load test cases
            if ($depth > 0) {
                // Load test cases
                FactoryService::TestCaseService()->LoadTestCases($category, $depth - 1);
            }
            
            // Add category to array
            $submissionTSE->AddCategory($category);
        }
    }

    public function ClearCategory($submissionId) 
    {
        $dbCategories = $this->CategoryDao->GetFilteredList(QueryParameter::Where('Submission', $submissionId));
        foreach ($dbCategories as $dbCategory)
        {
            $this->TestCaseService->ClearTestCases($dbCategory->Id);
        }
        $this->CategoryDao->DeleteFilteredList(QueryParameter::Where('Submission', $submissionId));
    }
}
