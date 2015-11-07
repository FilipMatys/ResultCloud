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
     * Project overview list item constructor
     */
    public function __construct(SubmissionTSE $submission)   {
        $this->Submission = $submission->ExportItem();
    }
}
