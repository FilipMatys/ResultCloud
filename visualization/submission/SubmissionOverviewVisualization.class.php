<?php

/**
 * SubmissionOverviewVisualisation short summary.
 *
 * SubmissionOverviewVisualisation description.
 *
 * @version 1.0
 * @author Filip
 */
class SubmissionOverviewVisualization
{
    /**
     * Submission Google chart
     * @var mixed
     */
    private $SubmissionOverviewChart;
    
    /**
     * Submission cateogories with all data
     * @var mixed
     */
    private $SubmissionOverviewList;
    
    /**
     * Submission custom objects
     * @var mixed
     */
    private $SubmissionOverviewCustoms;
    
    /**
     * Submission overview visualisation constructor
     */
    public function __construct()   {
        $this->SubmissionOverviewList = array();
    }
    
    /**
     * Set submission overview chart
     * @param mixed $submissionOverviewChart 
     */
    public function SetSubmissionOverviewChart($submissionOverviewChart)    {
        $this->SubmissionOverviewChart = $submissionOverviewChart->ExportObject();
    }
    
    /**
     * Add category to submission overview
     * @param mixed $submissionOverviewCategory 
     */
    public function SetSubmissionOverviewList($submissionOverviewList)  {
        $this->SubmissionOverviewList = $submissionOverviewList->ExportObject();
    }
    
    /**
     * Add submission overview custom 
     * @param mixed $submissionOverviewCustom 
     */
    public function AddSubmissionOverviewCustom($submissionOverviewCustom)  {
        $this->SubmissionOverviewCustoms[] = $submissionOverviewCustom->ExportObject();
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object
        $submissionOverviewVisualization = new stdClass();
    
        // Set values
        $submissionOverviewVisualization->SubmissionOverviewChart = $this->SubmissionOverviewChart;
        $submissionOverviewVisualization->SubmissionOverviewList = $this->SubmissionOverviewList;
        $submissionOverviewVisualization->SubmissionOverviewCustoms = $this->SubmissionOverviewCustoms;
        
        // return result
        return $submissionOverviewVisualization;
    }
}
