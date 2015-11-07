<?php

/**
 * SubmissionOverviewListItem short summary.
 *
 * SubmissionOverviewListItem description.
 *
 * @version 1.0
 * @author Filip
 */
class SubmissionOverviewListItem
{
    /**
     * Category name
     * @var mixed
     */
    private $Name;
    
    /**
     * Test case
     * @var mixed
     */
    private $TestCases;
    
    /**
     * Overal number of test cases
     * @var mixed
     */
    private $NumberOfTestCases;
    
    /**
     * Project overview list item constructor
     */
    public function __construct($name)   {
        $this->Name = $name;
        $this->TestCases = array();
        $this->NumberOfTestCases = 0;
    }
    
    /**
     * Set number of test cases
     * @param mixed $number 
     */
    public function SetNumberOfTestCases($number)  {
        $this->NumberOfTestCases = $number;
    }
    
    /**
     * Add test case
     * @param SubmissionOverviewListItemCase $submissionOverviewListItemCase 
     */
    public function AddTestCase(SubmissionOverviewListItemCase $submissionOverviewListItemCase) {
        $this->TestCases[] = $submissionOverviewListItemCase->ExportObject();
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object
        $listItem = new stdClass();
        
        // Set values
        $listItem->Name = $this->Name;
        $listItem->TestCases = $this->TestCases;
        $listItem->NumberOfTestCases = $this->NumberOfTestCases;
        
        // Return result
        return $listItem;
    }
}
