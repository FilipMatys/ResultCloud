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
    public function __construct($submission)   {
        $this->Submission = $submission->ExportItem();
    }
    
    /**
     * Set number of test cases
     * @param mixed $numberOfTestCases 
     */
    public function SetNumberOfTestCases($numberOfTestCases)    {
        $this->NumberOfTestCases = $numberOfTestCases;
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object
        $listItem = new stdClass();
        
        // Set values
        $listItem->Submission = $this->Submission;
        $listItem->NumberOfTestCases = $this->NumberOfTestCases;
        
        // Return result
        return $listItem;
    }
}
