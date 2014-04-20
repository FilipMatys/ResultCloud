<?php

/**
 * DifferenceOverviewListItem short summary.
 *
 * DifferenceOverviewListItem description.
 *
 * @version 1.0
 * @author Filip
 */
class DifferenceOverviewListItem
{
    /**
     * Test case name
     * @var mixed
     */
    private $Name;
    
    /**
     * Result set for each submission
     * @var mixed
     */
    private $ResultSets;
    
    /**
     * Difference overview list item constructor
     * @param mixed $name 
     */
    public function  __construct($name = "")  {
        $this->Name = $name;
        $this->ResultSets = array();
    }
    
    /**
     * Set name
     * @param mixed $name 
     */
    public function SetName($name)  {
        $this->Name = $name;
    }
    
    /**
     * Get name
     * @return mixed
     */
    public function GetName()   {
        return $this->Name;
    }
    
    /**
     * Add result set
     * @param DifferenceOverviewListItemResultSet $resultSet 
     */
    public function AddResultSet(DifferenceOverviewListItemResultSet $resultSet)    {
        $this->ResultSets[] = $resultSet;
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
        $listItem->ResultSets = array();
        foreach ($this->ResultSets as $resultSet)
        {
            $listItem->ResultSets[] = $resultSet->ExportObject();
        }
        // Return result
        return $listItem;
    }
}
