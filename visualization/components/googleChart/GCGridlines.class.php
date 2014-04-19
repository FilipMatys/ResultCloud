<?php

/**
 * GCGridlines short summary.
 *
 * GCGridlines description.
 *
 * @version 1.0
 * @author Filip
 */
class GCGridlines
{
    private $Count;
    
    /**
     * Google chart gridlines constructor
     */
    public function __construct($count)   {
        $this->Count = $count;
    }
    
    /**
     * Set Google chart gridlines count
     * @param mixed $count 
     */
    public function setCount($count)  {
        $this->Count = $count;
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object
        $gridlines = new stdClass();
    
        // Set values
        $gridlines->count = $this->Count;
        
        // return result
        return $gridlines;
    }
}
