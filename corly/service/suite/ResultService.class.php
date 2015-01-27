<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_SUITE);
Library::using(Library::CORLY_ENTITIES);

/**
 * ResultService short summary.
 *
 * ResultService description.
 *
 * @version 1.0
 * @author Filip
 */
class ResultService
{
    private $ResultDao;
    
    /**
     * Result service constructor
     */
    public function __construct()   {
        $this->ResultDao = new ResultDao();
    }
    
    /**
     * Save results of given test case
     * @param mixed $results 
     * @param mixed $testCaseId 
     */
    public function SaveResults($results, $testCaseId) {
        foreach ($results as $result)  {
            // Save result
            $this->ResultDao->Save($result->GetDbObject($testCaseId));
        }
    }
    
    /**
     * Load results for given test case
     * @param mixed $testCaseId 
     * @return mixed
     */
    public function LoadResults($testCaseTSE)    {
        // Load results for given 
        $dbResults = $this->ResultDao->GetFilteredList(QueryParameter::Where('TestCase', $testCaseTSE->GetId()))->ToList();
        
        // Initialize results
        $results = array();
        
        // Map db objects into TSE objects
        foreach ($dbResults as $dbResult) {
            // Create TSE object
            $result = new ResultTSE();
            $result->MapDbObject($dbResult);
            
            // Add to results array
            $testCaseTSE->AddResult($result);
        }
        
        // return results
        return $results;
    }
}
