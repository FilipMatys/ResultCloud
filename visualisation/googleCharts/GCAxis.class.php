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
}
