<?php

/**
 * DifferenceOverviewList short summary.
 *
 * DifferenceOverviewList description.
 *
 * @version 1.0
 * @author Filip
 */
class DifferenceOverviewList
{
    /**
     * List of list items
     * @var mixed
     */
    private $Items;
    
    /**
     * Difference overview list constructor
     */
    public function __construct()   {
        $this->Items = array();
    }
    
    /**
     * Add item to list
     * @param DifferenceOverviewListItem $differenceOverviewListItem 
     */
    public function AddItem(DifferenceOverviewListItem $differenceOverviewListItem)   {
        $this->Items[] = $differenceOverviewListItem;
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Initialize object
        $overviewList = new stdClass();
        // Set values
        $overviewList->Items = array();
        foreach ($this->Items as $item)
        {
            $overviewList[] = $item->ExportObject();
        }
        // Return result
        return $overviewList;
    }
}
