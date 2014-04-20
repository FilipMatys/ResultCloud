<?php

/**
 * DifferenceOverview short summary.
 *
 * DifferenceOverview description.
 *
 * @version 1.0
 * @author Filip
 */
class DifferenceOverview
{
    /**
     * Difference overiview chart
     * @var mixed
     */
    private $DifferenceOverviewChart;
    
    /**
     * Difference overview list
     * @var mixed
     */
    private $DifferenceOverviewList;
    
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
    public function SetDifferenceOverviewList(DifferenceOverviewList $differenceOverviewList)   {
        $this->DifferenceOverviewList = $differenceOverviewList->ExportObject();
    }
    
    /**
     * Add custom view
     * @param mixed $differenceOverviewCustom 
     */
    public function AddDifferenceOverviewCustom($differenceOverviewCustom)   {
        $this->DifferenceOverviewCustoms[] = $differenceOverviewCustom;
    }
}
