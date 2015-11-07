<?php

/**
 * SubmissionOverviewListItemCase short summary.
 *
 * SubmissionOverviewListItemCase description.
 *
 * @version 1.0
 * @author Filip
 */
class SubmissionOverviewListItemCase
{
    /**
     * Test case name
     * @var mixed
     */
    private $Name;
    
    /**
     * Test case results
     * @var mixed
     */
    private $Results;
    
    /**
     * Submission overview list item case
     * @param mixed $name 
     */
    public function __construct($name)   {
        $this->Name = $name;
        $this->Results = array();
    }
    
    /**
     * Get name
     * @return mixed
     */
    public function GetName()   {
        return $this->Name;
    }
    
    /**
     * Add result
     * @param SubmissionOverviewListItemCaseResult $submissionOverviewListItemCaseResult 
     */
    public function AddResult(SubmissionOverviewListItemCaseResult $submissionOverviewListItemCaseResult)   {
        $this->Results[] = $submissionOverviewListItemCaseResult->ExportObject();
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object
        $case = new stdClass();
        
        // Set values
        $case->Name = $this->Name;
        $case->Results = $this->Results;
        
        // Return result
        return $case;
    }
}
