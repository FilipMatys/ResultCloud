<?php

/**
 * DifferenceOverviewVisualization short summary.
 *
 * DifferenceOverviewVisualization description.
 *
 * @version 1.0
 * @author Filip
 */
class DifferenceOverviewVisualization
{
    /**
     * Difference overiview chart
     * @var mixed
     */
    private $DifferenceOverviewChart;
    
    /**
     * Difference overview lists
     * @var mixed
     */
    private $DifferenceOverviewLists;
    
    /**
     * Difference overview customs
     * @var mixed
     */
    private $DifferenceOverviewCustoms;
    
    /**
     * Difference overview constructor
     */
    public function __construct()   {
        $this->DifferenceOverviewCustoms = array();
        $this->DifferenceOverviewLists = array();
    }
    
    /**
     * Set overview chart
     * @param DifferenceOverviewChart $differenceOverviewChart 
     */
    public function SetDifferenceOverviewChart(DifferenceOverviewChart $differenceOverviewChart)    {
        $this->DifferenceOverviewChart = $differenceOverviewChart->ExportObject();
    }
    
    /**
     * Set overview list
     * @param DifferenceOverviewList $differenceOverviewList 
     */
    public function AddDifferenceOverviewList(DifferenceOverviewList $differenceOverviewList)   {
        $this->DifferenceOverviewLists[] = $differenceOverviewList->ExportObject();
    }
    
    /**
     * Add custom view
     * @param mixed $differenceOverviewCustom 
     */
    public function AddDifferenceOverviewCustom($differenceOverviewCustom)   {
        $this->DifferenceOverviewCustoms[] = $differenceOverviewCustom;
    }
}
