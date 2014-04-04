<?php

/**
 * Result short summary.
 *
 * Result description.
 *
 * @version 1.0
 * @author Filip
 */
class Result
{
    private $RKey;
    private $RValue;
    
    /**
     * Result constructor
     */
    public function __construct($rKey, $rValue)  {
        $this->RKey = $rKey;
        $this->RValue = $rValue;
    }
    
    /**
     * Get result as object to save to database
     * @param mixed $testCaseId 
     */
    public function GetDbObject($testCaseId)    {
        // Init object
        $result = new stdClass();
        // Set properties from base object
        $result->RKey = $this->RKey;
        $result->RValue = $this->RValue;
        // Set parent id (test case)
        $result->TestCase = $testCaseId;
        
        // return result
        return $result;
    }
    
    /**
     * Get result key
     */
    private function GetKey()   {
        return $this->Rkey;
    }
    
    /**
     * Get result value
     */
     private function GetValue()    {
        return $this->RValue;
     }
}
