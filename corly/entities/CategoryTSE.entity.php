<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

Library::using(Library::CORLY_ENTITIES, ['PaginatedTSE.entity.php']);

/**
 * Category short summary.
 *
 * Category description.
 *
 * @version 1.0
 * @author Filip
 */
class CategoryTSE extends PaginatedTSE
{
    public $Name;
    private $Id;
    private $TestCases;
    
    private $TestCasesCount;
    
    /**
     * Category constructor
     */
    public function __construct($Name = "")   {
        $this->Name = $Name;
        $this->TestCases = array();
        $this->TestCasesCount = 0;
        $this->Id;
    }

    /**
     * Get id
     * @return id
     */
    public function GetId() {
        return $this->Id;
    }
    
    /**
     * Add test case to category
     * @param test case
     */
    public function AddTestCase(TestCaseTSE $testCase)  {
        $this->TestCases[] = $testCase;
        ++$this->TestCasesCount;
    }
    
    /**
     * Get number of test cases of category
     * @return mixed
     */
    public function GetNumberOfTestCases()  {
        return $this->TestCasesCount;
    }
    
    /**
     * Splice array of test cases
     * @param mixed $offset 
     * @param mixed $length 
     */
    public function SpliceTestCases($offset, $length)   {
        $this->TestCases = array_splice($this->TestCases, $offset, $length);
    }
    
    /**
     * Get test cases
     * @return test cases
     */
    public function &GetTestCases()  {
        return $this->TestCases;
    }
    
    /**
     * Get test case by name
     * @param mixed $name 
     * @return mixed
     */
    public function GetTestCaseByName($name) {
        // Check if there are any test cases, if not
        // return null
        if (empty($this->TestCases))
            return null;
        
        // Iterate through test cases
        foreach ($this->TestCases as $testCase)
        {
            // If match is found, return it as a result
            if ($testCase->GetName() === $name)
                return $testCase;
        }
        
        // If none was found, return null
        return null;
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
        $category->Id = $this->Id;
        $category->Name = (string)$this->Name;
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
        $category->NumberOfTestCases = $this->TestCasesCount;
        $category->TestCases = array();
        
        // Export each test case
        foreach ($this->TestCases as $testCase) {
            $category->TestCases[] = $testCase->ExportObject();
        }        

        // return result
        return $category;
    }
}
