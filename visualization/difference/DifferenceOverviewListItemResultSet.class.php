<?php

/**
 * DifferenceOverviewListItemResultSet short summary.
 *
 * DifferenceOverviewListItemResultSet description.
 *
 * @version 1.0
 * @author Filip
 */
class DifferenceOverviewListItemResultSet
{
    /**
     * Result key
     * @var mixed
     */
    private $Key;
    
    /**
     * Values of given key
     * @var mixed
     */
    private $Values;
    
    /**
     * Summary of __construct
     * @param mixed $key 
     */
    public function __construct($key = "")  {
        $this->Key  = $key;
        $this->Values = array();
    }
    
    /**
     * Set key
     * @param mixed $key 
     */
    public function SetKey($key)    {
        $this->Key;
    }
    
    /**
     * Add value
     * @param mixed $value 
     */
    public function AddValue(DifferenceOverviewListItemResultSetValue $value)    {
        $this->Values[] = $value;
    }
    
    /**
     * Get last inserted value
     * @return last inserted value or null, if there was none
     */
    public function GetLastInsertedValue()  {
        // If there was no value inserted, return null
        if (empty($this->Values))
            return null;
        
        // Return last inserted value
        return end(array_values($this->Values));
    }
    
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object
        $resultSet = new stdClass();
        
        // Set values
        $resultSet->Key = $this->Key;
        $resultSet->Values = array();
        foreach ($this->Values as $value)
        {
            // Add exported value to set
            $resultSet[] = $value->ExportObject();
        }
        
        // Return result
        return $resultSet;
    }
}
