<?php

/**
 * GCOptions short summary.
 *
 * GCOptions description.
 *
 * @version 1.0
 * @author Filip
 */
class GCOptions
{
    private $Title;
    private $IsStacked;
    private $Fill;
    private $DisplayExactValues;
    private $VAxis;
    private $HAxis;
    private $DisplayOverviewHeader;
    private $Legend;
    private $Height;
    
    /**
     * Google charts options controller
     */
    public function __construct()   {
        $this->IsStacked = true;
        $this->DisplayExactValues = true;
        $this->DisplayOverviewHeader = false;
    }
    
    /**
     * Set Google chart title
     * @param mixed $title 
     */
    public function setTitle($title)    {
        $this->Title = $title;
    }
    
    /**
     * Set Google chart is stacked
     * @param mixed $isStacked 
     */
    public function setIsStacked($isStacked)  {
        $this->IsStacked = $isStacked;
    }
    
    /**
     * Set Google chart fill
     * @param mixed $fill 
     */
    public function setFill($fill)  {
        $this->Fill = $fill;
    }
    
    /**
     * Set Google chart display exact values
     * @param mixed $displayExactValues 
     */
    public function setDisplayExactValues($displayExactValues)  {
        $this->DisplayExactValues = $displayExactValues;
    }
    
    /**
     * Set if to display header for overview table
     * @param mixed $displayOverviewHeader
     */
    public function setDisplayOverviewHeader($displayOverviewHeader)    {
        $this->DisplayOverviewHeader = $displayOverviewHeader;
    }

    /**
     * Set Google chart hAxis
     * @param mixed $hAxis 
     */
    public function setHAxis($hAxis)    {
        $this->HAxis = $hAxis;
    }
    
    /**
     * Set Google chart vAxis
     * @param mixed $vAxis 
     */
    public function setVAxis($vAxis)    {
        $this->VAxis = $vAxis;
    }
    
    /**
     * Set legend for chart
     */
    public function setLegend($legend) {
        $this->Legend = $legend;
    }

    /**
     * Set charts height
     */
    public function setHeight($height)  {
        $this->Height = $height;
    }

    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object
        $options = new stdClass();
        
        // Set values
        $options->title = $this->Title;
        $options->isStacked = $this->IsStacked;
        $options->fill = $this->Fill;
        $options->displayExactValues = $this->DisplayExactValues;
        $options->displayOverviewHeader = $this->DisplayOverviewHeader;
        $options->height = $this->Height;
        $options->legend = $this->Legend;
        
        if (isset($this->VAxis))
            $options->vAxis = $this->VAxis->ExportObject();
        if (isset($this->HAxis))
            $options->hAxis = $this->HAxis->ExportObject();
        
        // Return result
        return $options;
    }
}
