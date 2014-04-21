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
     * List of view headers
     * @var mixed
     */
    private $Headers;
    
    /**
     * Difference overview list constructor
     */
    public function __construct()   {
        $this->Items = array();
        $this->Headers = array();
    }
    
    /**
     * Add item to list
     * @param DifferenceOverviewListItem $differenceOverviewListItem 
     */
    public function AddItem(DifferenceOverviewListItem $differenceOverviewListItem)   {
        $this->Items[] = $differenceOverviewListItem;
    }
    
    /**
     * Add header to list
     * @param mixed $header 
     */
    public function AddHeader($header)  {
        $this->Headers[] = $header;
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Initialize object
        $overviewList = new stdClass();
        // Set values
        $overviewList->Headers = $this->Headers;
        $overviewList->Items = array();
        foreach ($this->Items as $item)
        {
            $overviewList->Items[] = $item->ExportObject();
        }
        // Return result
        return $overviewList;
    }
}
