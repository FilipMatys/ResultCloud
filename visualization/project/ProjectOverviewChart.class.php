<?php

/**
 * ProjectOverviewChart short summary.
 *
 * ProjectOverviewChart description.
 *
 * @version 1.0
 * @author Filip
 */
class ProjectOverviewChart
{
    private $Chart;
    private $Types;
    
    /**
     * Project overview chart constructor
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
        $projectOverviewChart = new stdClass();
        
        // Set values
        $projectOverviewChart->Types = $this->Types;
        $projectOverviewChart->Chart = $this->Chart->ExportObject();
        
        //return result
        return $projectOverviewChart;
    }
}
