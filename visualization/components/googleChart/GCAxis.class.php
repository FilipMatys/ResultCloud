<?php

/**
 * GCAxis short summary.
 *
 * GCAxis description.
 *
 * @version 1.0
 * @author Filip
 */
class GCAxis
{
    private $Title;
    private $Gridlines;
    
    /**
     * Google chart axis controller
     */
    public function __construct()   {
        
    }
    
    /**
     * Set Google Chart Axis title 
     * @param mixed $title 
     */
    public function setTitle($title)  {
        $this->Title = $title;
    }
    
    /**
     * Set Google Chart Axis gridlines
     * @param mixed $gridlines 
     */
    public function setGridlines($gridlines)  {
        $this->Gridlines = $gridlines;    
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object
        $axis = new stdClass();
        
        // Set values
        $axis->title = $this->Title;
        
        if (isset($this->Gridlines))
            $axis->gridlines = $this->Gridlines->ExportObject();
        
        // return result
        return $axis;
    }
}
