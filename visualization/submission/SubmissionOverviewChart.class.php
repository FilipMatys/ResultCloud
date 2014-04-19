<?php

/**
 * SubmissionOverviewChart short summary.
 *
 * SubmissionOverviewChart description.
 *
 * @version 1.0
 * @author Filip
 */
class SubmissionOverviewChart
{
    private $Chart;
    private $Types;
    
    /**
     * Submission overview chart constructor
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
        $submissionOverviewChart = new stdClass();
        
        // Set values
        $submissionOverviewChart->Types = $this->Types;
        $submissionOverviewChart->Chart = $this->Chart->ExportObject();
        
        //return result
        return $submissionOverviewChart;
    }
}
