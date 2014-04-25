<?php

/**
 * DifferenceVisualization short summary.
 *
 * DifferenceVisualization description.
 *
 * @version 1.0
 * @author Filip
 */
class DifferenceVisualization
{
    /**
     * Visualize difference submission type
     * @param mixed $submissions 
     * @param mixed $type 
     * @param mixed $meta 
     * @return mixed
     */
    public static function Visualize($submissions, $type, $meta) {
        // Choose the right data based on component type
        switch($type)   {
            // Return difference lists
            case DifferenceOverviewType::VIEWLIST:
                return GLIBC_DifferenceOverviewList::GetDifferenceOverviewLists($submissions);
            
            case DifferenceOverviewType::GOOGLE_CHART:
                return GLIBC_DifferenceOverviewChart::GetDifferenceOverviewChart($submissions);
                
            case GLIBC_DifferenceOverviewType::DIFF_SUMMARY:
                return GLIBC_DifferenceOverviewDiffSummary::GetDifferenceOverviewDiffSummary($submissions);
                
            default:
                return null;
        }
    }
    
    /**
     * Get data depth based on component type
     * @param mixed $type 
     * @return mixed
     */
    public static function GetDataDepth($type)   {
        // Set data depth based on component type
        switch($type)   {
            case DifferenceOverviewType::VIEWLIST:
                return DataDepth::RESULT;
                
            case DifferenceOverviewType::GOOGLE_CHART:
                return DataDepth::RESULT;
                
            case GLIBC_DifferenceOverviewType::DIFF_SUMMARY:
                return DataDepth::RESULT;
                
            default:
                return DataDepth::SUBMISSION;
        }
    }
    
    /**
     * Get components for plugin
     * @return mixed
     */
    public static function GetViewComponents()   {
        return array(
                DifferenceOverviewComponent::GOOGLE_CHART,
                GLIBC_DifferenceOverviewComponent::DIFF_SUMMARY,
                DifferenceOverviewComponent::VIEWLIST
            );
    }
}
