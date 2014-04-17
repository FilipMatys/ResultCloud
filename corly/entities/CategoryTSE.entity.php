<?php

/**
 * Category short summary.
 *
 * Category description.
 *
 * @version 1.0
 * @author Filip
 */
class CategoryTSE
{
    public $Name;
    private $Id;
    private $TestCases;
    
    /**
     * Category constructor
     */
    public function __construct($Name = "")   {
        $this->Name = $Name;
        $this->TestCases = array();
    }
    
    /**
     * Add test case to category
     * @param test case
     */
    public function AddTestCase($testCase)  {
        $this->TestCases[] = $testCase;
    }
    
    /**
     * Get test cases
     * @return test cases
     */
    public function GetTestCases()  {
        return $this->TestCases;
    }
    
    /**
     * Get category name
     * @return name
     */
    public function GetName()   {
        return $this->Name;
    }
    
    /**
     * Get category as object to save to database
     * @param mixed $submissionId 
     */
    public function GetDbObject($submissionId)   {
        // Init object
        $category = new stdClass();
        // Set values from base object
        $category->Name = $this->Name;
        // Set parent id
        $category->Submission = $submissionId;
        
        // Return final object
        return $category;
    }
    
    /**
     * Map database object into TS entity
     * @param mixed $dbCategory 
     */
    public function MapDbObject($dbCategory)    {
        // Map values
        $this->Id = $dbCategory->Id;
        $this->Name = $dbCategory->Name;
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object
        $category = new stdClass();
        
        // Set values
        $category->Id = $this->Id;
        $category->Name = $this->Name;
        $category->TestCases = array();
        
        // Export each test case
        foreach ($this->TestCases as $testCase) {
            $category->TestCases[] = $testCase->ExportObject();
        }
        
        // return result
        return $category;
    }
}
