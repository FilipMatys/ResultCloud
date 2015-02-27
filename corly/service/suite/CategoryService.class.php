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
    public function LoadCategories($submissionTSE, $depth, $queryPagination = null)   {
        // Load categories for given submission
        $lCategories = FactoryDao::CategoryDao()->GetFilteredList(QueryParameter::Where('Submission', $submissionTSE->GetId()), $queryPagination);
        
        // Map each category into TSE object and load their test cases
        foreach ($lCategories->ToList() as $dbCategory)
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

        // Set pagination values
        $submissionTSE->SetTotalCount($lCategories->GetTotalCount());
        $submissionTSE->SetPage($lCategories->GetPage());
    }

    /**
     * Clear category
     * @param submissionId
     */
    public function ClearCategory($submissionId) 
    {
        $dbCategories = FactoryDao::CategoryDao()->GetFilteredList(QueryParameter::Where('Submission', $submissionId))->ToList();
        foreach ($dbCategories as $dbCategory)
        {
            FactoryService::TestCaseService()->ClearTestCases($dbCategory->Id);
        }
        FactoryDao::CategoryDao()->DeleteFilteredList(QueryParameter::Where('Submission', $submissionId));
    }
}
