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
    private $SubmissionOverviewCategories;
    
    /**
     * Submission custom objects
     * @var mixed
     */
    private $SubmissionOverviewCustoms;
    
    /**
     * Submission overview visualisation constructor
     */
    public function __construct()   {
        $this->SubmissionOverviewCategories = array();
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
    public function AddSubmissionOverviewCategory($submissionOverviewCategory)  {
        $this->SubmissionOverviewCategories[] = $submissionOverviewCategory->ExportObject();
    }
    
    /**
     * Add submission overview custom 
     * @param mixed $submissionOverviewCustom 
     */
    public function AddSubmissionOverviewCustom($submissionOverviewCustom)  {
        $this->SubmissionOverviewCustoms[] = $submissionOverviewCustom->ExportObject();
    }
}
