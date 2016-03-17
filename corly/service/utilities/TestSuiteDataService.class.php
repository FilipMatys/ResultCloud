<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);

class TestSuiteDataService	{

	/**
	 * Load submissions into given project
	 * @param projectTSE
	 * @param data depth
	 * @param query pagination (not required)
	 * @return projectTSE with loaded submissions
	 */
	public static function LoadSubmissions($projectTSE, $dataDepth, QueryPagination $queryPagination = null)	{
		FactoryService::SubmissionService()->LoadSubmissions($projectTSE, $dataDepth, $queryPagination);
	}

	/**
	 * Load categories into given submission
	 * @param submissionTSE
	 * @param data depth
	 * @param query pagination (not required)
	 * @return submissionTSE with loaded categories
	 */
	public static function LoadCategories($submissionTSE, $dataDepth, QueryPagination $queryPagination = null)	{
		FactoryService::CategoryService()->LoadCategories($submissionTSE, $dataDepth, $queryPagination);
	} 

    /**
     * Load submission that is before the given one, given by sequence number
     */
    public static function GetPreviousRevision(SubmissionTSE $submissionTSE)    {
        // First we should check, if the submission has valid sequence number
        $sequenceNumber = $submissionTSE->GetSequenceNumber();
        
        // The number is not even set || There is no previous revision
        if ($sequenceNumber == 0 || $sequenceNumber == 1)   {
            return null;
        }

        // Load the submission
        $dbSubmission = FactoryService::SubmissionService()->GetFilteredList(
                QueryParameter::WhereAnd(array('Project', 'SequenceNumber'), array($submissionTSE->GetProjectId(), $sequenceNumber - 1))
        )->Single();

        // Make it a TSE object
        $resultTSE = new SubmissionTSE();
        $resultTSE->MapDbObject($dbSubmission);
        
        // Return result
        return $resultTSE;
    }

    /**
     * Load submission that is after the given one, given by sequence number. Also load 
     * data, if needed
     */
    public static function GetNextRevision(SubmissionTSE $submissionTSE) {
        // First we should check, if the submission has valid sequence number
        $sequenceNumber = $submissionTSE->GetSequenceNumber();
        
        // The number is not even set
        if ($sequenceNumber == 0)   {
            return null;
        }

        // Load the submission
        $dbSubmission = FactoryService::SubmissionService()->GetFilteredList(
                QueryParameter::WhereAnd(array('Project', 'SequenceNumber'), array($submissionTSE->GetProjectId(), $sequenceNumber + 1))
        )->Single();

        // Check if the submission exists
        if (is_null($dbSubmission))
            return null;

        // Make it a TSE object
        $resultTSE = new SubmissionTSE();
        $resultTSE->MapDbObject($dbSubmission);
        
        // Return result
        return $resultTSE;
    }
}

?>