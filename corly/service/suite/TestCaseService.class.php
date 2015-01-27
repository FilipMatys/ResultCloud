<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_SUITE);
Library::using(Library::CORLY_SERVICE_SUITE);
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
    private $TestCaseDao;
    
    private $ResultService;
    
    /**
     * TestCase service constructor
     */
    public function __construct()   {
        $this->TestCaseDao = new TestCaseDao();
        $this->ResultService = new ResultService();
    }
    
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
            $testCaseId = $this->TestCaseDao->Save($testCase->GetDbObject($categoryId));
            $this->ResultService->SaveResults($results, $testCaseId);
        }
    }
    
    /**
     * Load test cases for given category
     * @param mixed $categoryId 
     * @return mixed
     */
    public function LoadTestCases($categoryTSE, $depth)  {
        // Load test cases
        $dbTestCases = $this->TestCaseDao->GetFilteredList(QueryParameter::Where('Category', $categoryTSE->GetId()))->ToList();
        
        // Map test cases into TSE objects and load results
        foreach ($dbTestCases as $dbTestCase)
        {
            // Create TSE object
            $testCase = new TestCaseTSE();
            $testCase->MapDbObject($dbTestCase);
            
            // If not reached the depth, load results
            if ($depth > 0) {
                // Load results and add them to test case
                $this->ResultService->LoadResults($testCase);
            }
            
            // Add test case to array
            $categoryTSE->AddTestCase($testCase);
        }
        
        // return array of test cases
        return $testCases;
    }
}
