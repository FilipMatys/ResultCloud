<?php

/**
 * OverviewChart short summary.
 *
 * OverviewChart description.
 *
 * @version 1.0
 * @author Filip
 */
class OverviewChart
{
    protected $Chart;
    protected $Types;
    
    /**
     * Difference overview chart constructor
     */
    public function __construct()   {
        $this->Types;
    }
    
    /**
     * Add chart type for GUI selection
     * @param mixed $type 
     */
    public function AddType($type)   {
        $this->Types[] = $type;
    }
    
    /**
     * Set chart object
     * @param mixed $chart 
     */
    public function SetChart($chart)    {
        $this->Chart = $chart;
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object
        $overviewChart = new stdClass();
        
        // Set values
        $overviewChart->Types = $this->Types;
        $overviewChart->Chart = $this->Chart->ExportObject();
        
        //return result
        return $overviewChart;
    }    
}
