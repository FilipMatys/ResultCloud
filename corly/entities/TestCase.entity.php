<?php

/**
 * TestCase short summary.
 *
 * TestCase description.
 *
 * @version 1.0
 * @author Filip
 */
class TestCase
{
    private $Name;
    private $Results;
    
    /**
     * TestCase constructor
     */
    public function __construct($Name)   {
        $this->Name = $Name;
        $this->Results = array();
    }
    
    /**
     * Get test case as object to save to database
     * @param mixed $categoryId 
     */
    public function GetDbObject($categoryId)   {
        // Init object
        $testCase = new stdClass();
        // Assign values from base object
        $testCase->Name = $this->Name;
        // Set parent id (category)
        $testCase->Category = $categoryId;
        
        // Return test case
        return $testCase;
    }
    
    /**
     * Add result to TestCase
     * @param result
     */
    public function AddResult($result)  {
        $this->Results[] = $result;
    }
    
    /**
     * Get results
     * @return results
     */
    public function GetResults()  {
        return $this->Results;
    }
    
    /**
     * Get test case name
     * @return name
     */
    public function GetName()   {
        return $this->Name;
    }
}
