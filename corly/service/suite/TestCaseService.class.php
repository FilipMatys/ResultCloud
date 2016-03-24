<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryDao.class.php']);
Library::using(Library::CORLY_ENTITIES);


/**
 * TestCaseService short summary.
 *
 * TestCaseService description.
 *
 * @version 1.0
 * @author Filip
 */
class TestCaseService
{
    /**
     * Save test cases of given category
     * @param mixed $testCases 
     * @param mixed $categoryId 
     */
    public function SaveTestCases($testCases, $categoryId)    {
        foreach($testCases as $testCase)    {
            // Prepare results
            $results = $testCase->GetResults();
            
            // Save test case and results
            $testCaseId = FactoryDao::TestCaseDao()->Save($testCase->GetDbObject($categoryId));
            $start = microtime(true);
            FactoryService::ResultService()->SaveResults($results, $testCaseId); 
        }
    }
    
    /**
     * Load test cases for given category
     * @param mixed $categoryId 
     * @return mixed
     */
    public function LoadTestCases($categoryTSE, $depth)  {
        // Load test cases
        $lTestCases = FactoryDao::TestCaseDao()->GetFilteredList(QueryParameter::Where('Category', $categoryTSE->GetId()));
        
        // Map test cases into TSE objects and load results
        foreach ($lTestCases->ToList() as $dbTestCase)
        {
            // Create TSE object
            $testCase = new TestCaseTSE();
            $testCase->MapDbObject($dbTestCase);
            
            // If not reached the depth, load results
            if ($depth > 0) {
                // Load results and add them to test case
                FactoryService::ResultService()->LoadResults($testCase);
            }
            
            // Add test case to array
            $categoryTSE->AddTestCase($testCase);
        }

        // Set pagination values
        $categoryTSE->SetPage($lTestCases->GetPage());
        $categoryTSE->SetTotalCount($lTestCases->GetTotalCount());
        
        // return array of test cases
        return $testCases;
    }

    public function ClearTestCases($categoryId) {
        $dbTestCases = FactoryDao::TestCaseDao()->GetFilteredList(QueryParameter::Where('Category', $categoryId))->ToList();
        foreach ($dbTestCases as $dbTestCase)
        {
            FactoryService::ResultService()->ClearResults($dbTestCase->Id);
        }
        FactoryDao::TestCaseDao()->DeleteFilteredList(QueryParameter::Where('Category', $categoryId));
    }
}
