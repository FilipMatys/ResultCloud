<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryDao.class.php']);

/**
 * AnalyzerService short summary.
 *
 * AnalyzerService description.
 *
 * @version 1.0
 * @author Filip
 */
class AnalyzerService
{
    /**
     * Save categories of given submission
     * @param AnalyzerTSE $results
     */
    public function SaveAnalyzerResults($results)
    {
        foreach ($results as $result) {
            // Save analyze results
            FactoryDao::AnalyzerDao()->Save($result->GetDbObject());
        }
    }
    
    /**
     * Load results for given analyzer
     * @param string $analyzer
     * @return LINQ
     */
    public function LoadResultsByAnalyzer($analyzer, $queryPagination = null)
    {
        // Load categories for given submission
        $results = FactoryDao::AnalyzerDao()->GetFilteredList(QueryParameter::Where('Analyzer', $analyzer), $queryPagination);
        
        $resultsTSE = array();
        // Map each category into TSE object and load their test cases
        foreach ($results->ToList() as $result) {
            $resultTSE = new AnalyzerTSE();
            $resultTSE->MapDbObject($result);
            $resultsTSE[] = $resultTSE;
        }

        return new LINQ($resultsTSE);
    }

    /**
     * Clear analyzer results
     * @param string $analyzer
     */
    public function ClearResults($analyzer)
    {
        FactoryDao::AnalyzerDao()->DeleteFilteredList(QueryParameter::Where('Analyzer', $analyzer));
    }
    /**
     * Clear analyzer results
     * @param string $analyzer
     */
    public function ClearBySubmission($Submission)
    {
        FactoryDao::AnalyzerDao()->DeleteFilteredList(QueryParameter::Where('Submission', $Submission));
    }
}
