<?php

/**
 * Result short summary.
 *
 * Result description.
 *
 * @version 1.0
 * @author Filip
 */
class ResultTSE
{
    private $Id;
    private $RKey;
    private $RValue;
    
    /**
     * Result constructor
     */
    public function __construct($rKey = "", $rValue = "")  {
        $this->RKey = $rKey;
        $this->RValue = $rValue;
        $this->Id = 0;
    }

    /**
     * Get id
     * @return id
     */
    public function GetId() {
        return $this->Id;
    }
    
    /**
     * Get result key
     */
    public function GetKey()   {
        return $this->RKey;
    }
    
    /**
     * Get result value
     */
     public function GetValue()    {
        return $this->RValue;
     }
     
     /**
      * Map database object into TS entity
      * @param mixed $dbResult 
      */
     public function MapDbObject($dbResult)   {
         // Map values
         $this->Id = $dbResult->Id;
         $this->RKey = $dbResult->RKey;
         $this->RValue = $dbResult->RValue;
     }
     
     /**
      * Export object for serialization
      * @return mixed
      */
     public function ExportObject()  {
         // Init object
         $result = new stdClass();
         
         // Set values
         $result->Id = $this->Id;
         $result->RKey = $this->RKey;
         $result->RValue = $this->RValue;
         
         // return result
         return $result;
     }
     
     /**
      * Get result as object to save to database
      * @param mixed $testCaseId 
      */
     public function GetDbObject($testCaseId)    {
         // Init object
         $result = new stdClass();
         // Set properties from base object
         $result->Id = $this->Id;
         $result->RKey = (string)$this->RKey;
         $result->RValue = (string)$this->RValue;
         // Set parent id (test case)
         $result->TestCase = $testCaseId;
         
         // return result
         return $result;
     }
}
