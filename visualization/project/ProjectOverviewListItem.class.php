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
    private $Submission;
    
    /**
     * Number of test cases of given submission
     * @var mixed
     */
    private $NumberOfTestCases;
    
    /**
     * Project overview list item constructor
     */
    public function __construct()   {
    
    }
    
    /**
     * Set submission
     * @param mixed $submission 
     */
    public function SetSubmission($submission)  {
        $this->Submission = $submission;
    }
    
    /**
     * Set number of test cases
     * @param mixed $numberOfTestCases 
     */
    public function SetNumberOfTestCases($numberOfTestCases)    {
        $this->NumberOfTestCases = $numberOfTestCases;
    }
}
