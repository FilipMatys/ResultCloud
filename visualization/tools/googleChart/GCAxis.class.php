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
    private $TextPosition;
    
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
     * Set text position
     * @param mixed text position
     */
    public function setTextPosition($textPosition)    {
        $this->TextPosition = $textPosition;
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
        $axis->textPosition = $this->TextPosition;
        
        if (isset($this->Gridlines))
            $axis->gridlines = $this->Gridlines->ExportObject();
        
        // return result
        return $axis;
    }
}
