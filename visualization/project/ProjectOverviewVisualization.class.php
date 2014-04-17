<?php

/**
 * ProjectOverviewVisualisation short summary.
 *
 * ProjectOverviewVisualisation description.
 *
 * @version 1.0
 * @author Filip
 */
class ProjectOverviewVisualization
{
    /**
     * Google chart object
     * @var mixed
     */
    private $ProjectOverviewChart;
    
    /**
     * Project overview list
     * @var mixed
     */
    private $ProjectOverviewList;
    
    /**
     * Project overview custom objects
     * @var mixed
     */
    private $ProjectOverviewCustoms;
    
    /**
     * Project overview visualisation constructor
     */
    public function __construct()   {
        // Initialize customs as array
        $this->ProjectOverviewCustoms = array();
    }
    
    /**
     * Set project overview chart
     * @param mixed $googleChart 
     */
    public function SetProjectOverviewChart($googleChart)   {
        $this->ProjectOverviewChart = $googleChart->ExportObject();
    }
    
    /**
     * Set project overview list
     * @param mixed $projectOverviewList 
     */
    public function SetProjectOverviewList($projectOverviewList)    {
        $this->ProjectOverviewList = $projectOverviewList->ExportObject();
    }
    
    /**
     * Add custom project overview
     * @param mixed $projectOverviewCustom 
     */
    public function AddProjectOverviewCustom($projectOverviewCustom)    {
        $this->ProjectOverviewCustoms[] = $projectOverviewCustom->ExportObject();
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object
        $projectOverviewVisualisation = new stdClass();
        
        // Set values
        $projectOverviewVisualisation->ProjectOverviewChart = $this->ProjectOverviewChart;
        $projectOverviewVisualisation->ProjectOverviewList = $this->ProjectOverviewList;
        $projectOverviewVisualisation->ProjectOverviewCustoms = $this->ProjectOverviewCustoms;
        
        // Return object
        return $projectOverviewVisualisation;
    }
}
