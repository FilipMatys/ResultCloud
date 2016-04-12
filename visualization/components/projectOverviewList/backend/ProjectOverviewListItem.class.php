<?php

/**
 * ProjectOverviewListItem short summary.
 *
 * ProjectOverviewListItem description.
 *
 * @version 1.0
 * @author Filip
 */
class ProjectOverviewListItem
{
    /**
     * Submission object
     * @var mixed
     */
    public $Submission;
    
    /**
     * Number of test cases of given submission
     * @var mixed
     */
    public $NumberOfTestCases;

    /**
     * Number of changes in submission
     * @var stdClass
     */
    public $AnalyzingResults;
    
    /**
     * Project overview list item constructor
     */
    public function __construct(SubmissionTSE $submission, $AnalyzingResults = null)   {
        $this->Submission = $submission->ExportItem();
        if (!is_null($AnalyzingResults)) {
            $this->AnalyzingResults = $AnalyzingResults;
        } else {
            $this->AnalyzingResults = new stdClass();
            $this->AnalyzingResults->Good = 0;
            $this->AnalyzingResults->Bad = 0;
            $this->AnalyzingResults->Strange = 0;
        }
    }
}
